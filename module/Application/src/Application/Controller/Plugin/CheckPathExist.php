<?php
namespace Application\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
 
class CheckPathExist extends AbstractPlugin{
    
    public function checkPatchExist($path, $newName, $typeName)
    {
        if (file_exists($path . $newName . '_' . $typeName)) {
            $newName = md5(uniqid(mt_rand(), true));
            $this->checkPatchExist($path, $newName, $typeName);
        } else {
            return $newName . '_' . $typeName;
        }
    }
}
?>