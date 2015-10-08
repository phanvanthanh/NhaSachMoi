<?php
namespace Application\Model\Entity;

class Kho
{
    protected $id_kho;
    protected $ten_kho;
    protected $dia_chi_kho;

    public function exchangeArray($data)
    {
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->ten_kho = (isset($data['ten_kho'])) ? $data['ten_kho'] : null;
        $this->dia_chi_kho = (isset($data['dia_chi_kho'])) ? $data['dia_chi_kho'] : null;
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdKho($id_kho)
    {
        $this->id_kho=$id_kho;
    }

    public function getIdKho()
    {
        return $this->id_kho;
    }

    public function setTenKho($ten_kho)
    {
        $this->ten_kho=$ten_kho;
    }

    public function getTenKho()
    {
        return $this->ten_kho;
    }

    public function setDiaChiKho($dia_chi_kho)
    {
        $this->dia_chi_kho=$dia_chi_kho;
    }

    public function getDiaChiKho()
    {
        return $this->dia_chi_kho;
    }

    
    
}
