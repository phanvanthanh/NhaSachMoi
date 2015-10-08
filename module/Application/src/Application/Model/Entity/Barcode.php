<?php
namespace Application\Model\Entity;

class Barcode
{
    
    protected $id_barcode;
    protected $id_kho;
    protected $ten_barcode;
    protected $length;
    protected $state;   
    

    public function exchangeArray($data)
    {
        $this->id_barcode = (isset($data['id_barcode'])) ? $data['id_barcode'] : null;
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->ten_barcode = (isset($data['ten_barcode'])) ? $data['ten_barcode'] : null;
        $this->length = (isset($data['length'])) ? $data['length'] : null;
        $this->state = (isset($data['state'])) ? $data['state'] : null;
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdBarcode($id_barcode)
    {
        $this->id_barcode=$id_barcode;
    }

    public function getIdBarcode()
    {
        return $this->id_barcode;
    }

    public function setIdKho($id_kho)
    {
        $this->id_kho=$id_kho;
    }

    public function getIdKho()
    {
        return $this->id_kho;
    }

    public function setTenBarcode($ten_barcode)
    {
        $this->ten_barcode=$ten_barcode;
    }

    public function getTenBarcode()
    {
        return $this->ten_barcode;
    }

    public function setLength($length)
    {
        $this->length=$length;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setState($state)
    {
        $this->state=$state;
    }

    public function getState()
    {
        return $this->state;
    }

    

    
}
