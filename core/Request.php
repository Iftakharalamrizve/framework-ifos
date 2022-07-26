<?php

namespace e2c\mvc;


class Request
{
    use RedirectTrait;
    /**
     * @var array
     */
    public array $inputs = [];

    /**
     * @var array|string[]
     */
    protected array $rules = [
        'required' => 'This field is required',
        'email'=> 'This field must be valid email address',
        'min'=>'Min length of this field must be {min}',
        'max'=>'Min length of this field must be {max}',
        'match' => 'This field must be the same as {match}',
        'unique'=> 'Record with with this {unique} already exists'
    ];
    /**
     * @var array
     */
    public array $errors = [] ;
    /**
     * @var array
     */
    private array $message = [];



    public function __construct()
    {
        $this->inputs = $this->getBody();
    }

    /**
     * @return false|mixed|string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path,'?');
        if($position === false){
            return $path;
        }
        return substr($path,0,$position);

    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    public function isGet() : bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * @return bool
     */
    public function isPost() : bool
    {
        return $this->getMethod() === 'post';
    }


    /**
     * @return array
     */
    public function getBody() : array
    {
        $body = [];
        if($this->isGet()){
            foreach ($_GET as $key=>$value){
                $body[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }

        if($this->isPost()){
            foreach ($_POST as $key=>$value){
                $body[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    /**
     * @param array $data
     * @param array $attribute
     * @param array $message
     * @return array|false
     */
    public function validateRequest( array $attribute  , array $message = [] )
    {
        $attributeList = $attribute;
        $messageList = $message;
        if(!count($attribute)){
            $attributeList = $this->attributes()??[];
            $messageList = $this->messages()??[];
        }
        $this->message = $messageList;
        $errorInfo = $this->validationErrorGenerate($this->inputs,$attributeList );
        if(!$errorInfo){
            return false;
        }
        return  $errorInfo;
    }


    /**
     * @param $data
     * @param $attribute
     * @return array
     */
    private function validationErrorGenerate( $data , $attribute ):array
    {
        if(count($attribute)>0) foreach ($attribute as $attributeKey=> $item){
            $filedData = $data[$attributeKey]??'';
            if(array_key_exists($attributeKey,$this->errors)){
                continue;
            }
            $explodeAllAttribute = explode('|',$item);
            foreach ($explodeAllAttribute as $value){

                $pos = strpos($value,':');
                $forMaxMinMatch='';
                if($pos){
                    $ruleKey = substr($value,0,$pos);
                    $forMaxMinMatch = substr($value,$pos+1,strlen($value));
                }else{
                    $ruleKey = $value ;
                }

                $this->validateRequestData($filedData,$ruleKey,$attributeKey,$forMaxMinMatch);
            }
        }
        else{
            $this->errors = [] ;
        }
        return $this->errors;
    }

    /**
     * @param     $info
     * @param     $ruleName
     * @param     $attribute
     * @param int $forMaxMinMatch
     */
    private function validateRequestData( $info , $ruleName , $attribute,  $forMaxMinMatch=0)
    {
        if ($ruleName === 'required' && !$info) {
            $this->addErrorByRule($attribute,$ruleName);
        }
        if ($ruleName === 'email' && !filter_var($info, FILTER_VALIDATE_EMAIL)) {
            $this->addErrorByRule($attribute,$ruleName);
        }
        if ($ruleName === 'min' && strlen($info) < $forMaxMinMatch) {
            $this->addErrorByRule($attribute, $ruleName,$forMaxMinMatch,true);
        }
        if ($ruleName === 'max' && strlen($info) > $forMaxMinMatch) {
            $this->addErrorByRule($attribute, $ruleName,$forMaxMinMatch,true);
        }
        if ($ruleName === 'match') {
            if($info !== $this->inputs[$attribute]??''){
                $this->addErrorByRule($attribute,$ruleName,$forMaxMinMatch,true);
            }

        }
        if ($ruleName === 'unique') {
            $classNameAndProperty = explode(',',$forMaxMinMatch);
            [$tableName, $columName] = $classNameAndProperty;
            $id = $classNameAndProperty[2]??null;
            $db = Application::$app->db;
            $statement = $db->prepare("SELECT * FROM $tableName WHERE $columName = :$columName");
            $statement->bindValue(":$columName", $info);
            $statement->execute();
            $record = $statement->fetchObject();
            if($id != null){
                if($id != $record->id){
                    $this->addErrorByRule($attribute,$ruleName,$columName,true);
                }
            }elseif ($record){
                $this->addErrorByRule($attribute,$ruleName,$columName,true);
            }
        }
    }

    /**
     * @param        $attribute
     * @param        $rule
     * @param string $lenght
     * @param false  $isReplace
     */
    private function addErrorByRule( $attribute, $rule, $replaceData='', bool $isReplace=false)
    {
        if(array_key_exists($rule,$this->rules)){

            $messageInfo = $this->rules[$rule];
            $messageKeyOne = $attribute.'.'.$rule ;
            $messageKeyTwo = $rule==='required' ? $attribute : $messageKeyOne;
            if($isReplace){
                if(array_key_exists($messageKeyOne,$this->message)){
                    $messageInfo = str_replace("{{$rule}}",$replaceData,$this->message[$messageKeyOne]);
                }else{
                    $messageInfo = str_replace("{{$rule}}",$replaceData,$this->rules[$rule]);
                }
            }elseif(array_key_exists($messageKeyTwo,$this->message) || array_key_exists($messageInfo,$this->message)){
                $messageInfo = $this->message[$messageKeyOne] ?? $this->message[$messageKeyTwo];
            }
            $this->errors[$attribute] = $messageInfo ;
        }

    }

    /**
     * @param $attributeName
     * @return mixed|string
     */
    public function old ( $attributeName)
    {
        if(array_key_exists($attributeName,$this->inputs)){
            return $this->inputs[$attributeName];
        }
        return '';
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function error(string $attribute):bool
    {
        if(array_key_exists($attribute,$this->errors))
        {
            return true;
        }
        return false;
    }






}