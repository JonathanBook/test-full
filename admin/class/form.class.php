<?php
class form {

    private $action='action="#"';
    private $method ='method="POST"';
    private $formContent ="";
    
    function __construct($action=null,$method=null,$name,$id=null ,$class=null,$option=null)
    {
        /* Paramètre formulaire de base */
        if($action!=null)$this->action = 'action="' .$action.'"';
        if($method!=null)$this->method = 'method="'.$method.'"';
        if($id!=null)$this->method .= 'id="'.$id.'"';
        if($class!=null)$this->method .= 'class="'.$class.'"';
        if($name!=null)$this->method .= 'name="'.$name.'"';
        if($option!=null)$this->method.=$option;
    }



    public function newForm():string
    {
        $html = '<form '.$this->action.' '.$this->method.' >';

        $html.= $this->formContent;

        $html.='</form>';

        return $html;
    }

    public function addhtml($html){
        $this->formContent.=$html;
    }
    public function addLabel($label,$for=null,$class=null,$id=null){
        $this->formContent.='<label';

        if($for!=null)$this->formContent.=' for="'.$for.'"';
        if($class!=null)$this->formContent.=' class="'.$class.'"';
        if($id!=null)$this->formContent.=' id="'.$id.'"';
        $this->formContent.='>';
        $this->formContent.=$label;
        $this->formContent.='</label>';
    }

    public function addInput($type ,$name ,$class=null,$placeholder =null,$value=null,$id=null,string $option=null){

        $this->formContent.='<input type="'.$type.'" name="'.$name.'"';

        if($id!=null)$this->formContent.='  id="'.$id.'" ';
      
        if($class!=null)$this->formContent.='  class="'.$class.'" ';
      
        if($placeholder!=null)$this->formContent.='  placeholder="'.$placeholder.'" ';
     
        if($value!=null)$this->formContent.='  value="'.$value.'" ';

        if($option!=null)$this->formContent.=$option;

        $this->formContent.='/>';
    }

    function addSelected(string $name, array $value,array $titre=null, $selected=null, string $class=null, string $id=null){

        $this->formContent.= ' <select name="'.$name.'" id="'.$id.'" class="'.$class.'" >';

        if($titre == null){
            $titre = $value;
        }

            foreach ($value as $key => $data) {

                $this->formContent.=  '<option value=" ' . $data . '"';


                if ($selected!=null && $selected == $data) {

                    $this->formContent.=  'selected';
                }

                $this->formContent.=  '>' . $titre[$key]. '</option>';

            }
    
            $this->formContent.= ' </select>';
    
    }

}
