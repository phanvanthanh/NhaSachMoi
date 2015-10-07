<?php
namespace Application\Model\Entity;

class GiaXuat
{
    
    
    protected $id_gia_xuat;
    protected $id_san_pham;
    protected $id_kenh_phan_phoi;
    protected $gia_xuat;

   
    

    public function exchangeArray($data)
    {
        $this->id_gia_xuat = (isset($data['id_gia_xuat'])) ? $data['id_gia_xuat'] : null;
        $this->id_san_pham = (isset($data['id_san_pham'])) ? $data['id_san_pham'] : null;
        $this->id_kenh_phan_phoi = (isset($data['id_kenh_phan_phoi'])) ? $data['id_kenh_phan_phoi'] : null;
        $this->gia_xuat = (isset($data['gia_xuat'])) ? $data['gia_xuat'] : null;
        
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdSanPham($id_san_pham)
    {
        $this->id_san_pham=$id_san_pham;
    }

    public function getIdSanPham()
    {
        return $this->id_san_pham;
    }

    public function setIdKenhPhanPhoi($id_kenh_phan_phoi)
    {
        $this->id_kenh_phan_phoi=$id_kenh_phan_phoi;
    }

    public function getIdKenhPhanPhoi()
    {
        return $this->id_kenh_phan_phoi;
    }

    public function setGiaXuat($gia_xuat)
    {
        $this->gia_xuat=$gia_xuat;
    }

    public function getGiaXuat()
    {
        return $this->gia_xuat;
    }

    public function setIdGiaXuat($id_gia_xuat)
    {
        $this->id_gia_xuat=$id_gia_xuat;
    }

    public function getIdGiaXuat()
    {
        return $this->id_gia_xuat;
    }

    


    
}
