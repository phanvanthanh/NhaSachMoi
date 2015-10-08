<?php
namespace Application\Model\Entity;

class DonViTinh
{
    
    protected $id_don_vi_tinh;
    protected $id_kho;
    protected $don_vi_tinh;
    
    public function exchangeArray($data)
    {
        $this->id_don_vi_tinh = (isset($data['id_don_vi_tinh'])) ? $data['id_don_vi_tinh'] : null;
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->don_vi_tinh = (isset($data['don_vi_tinh'])) ? $data['don_vi_tinh'] : null;
        
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdDonViTinh($id_don_vi_tinh)
    {
        $this->id_don_vi_tinh=$id_don_vi_tinh;
    }

    public function getIdDonViTinh()
    {
        return $this->id_don_vi_tinh;
    }

    public function setIdKho($id_kho)
    {
        $this->id_kho=$id_kho;
    }

    public function getIdKho()
    {
        return $this->id_kho;
    }

    public function setDonViTinh($don_vi_tinh)
    {
        $this->don_vi_tinh=$don_vi_tinh;
    }

    public function getDonViTinh()
    {
        return $this->don_vi_tinh;
    }


    
}
