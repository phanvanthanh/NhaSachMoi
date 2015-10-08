<?php
namespace Application\Model\Entity;

class LoaiSanPham
{
    protected $id_loai_san_pham;
    protected $id_kho;
    protected $loai_san_pham;

    public function exchangeArray($data)
    {
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->id_loai_san_pham = (isset($data['id_loai_san_pham'])) ? $data['id_loai_san_pham'] : null;
        $this->loai_san_pham = (isset($data['loai_san_pham'])) ? $data['loai_san_pham'] : null;
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdLoaiSanPham($id_loai_san_pham)
    {
        $this->id_loai_san_pham=$id_loai_san_pham;
    }

    public function getIdLoaiSanPham()
    {
        return $this->id_loai_san_pham;
    }

    public function setIdKho($id_kho)
    {
        $this->id_kho=$id_kho;
    }

    public function getIdKho()
    {
        return $this->id_kho;
    }    

    public function setLoaiSanPham($loai_san_pham)
    {
        $this->loai_san_pham=$loai_san_pham;
    }

    public function getLoaiSanPham()
    {
        return $this->loai_san_pham;
    }

    
    
}
