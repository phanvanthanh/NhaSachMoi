<?php
namespace Application\Model\Entity;

class KenhPhanPhoi
{
    
    
    protected $id_kenh_phan_phoi;
    protected $id_kho;
    protected $kenh_phan_phoi;
    protected $chiet_khau;

    public function exchangeArray($data)
    {
        $this->id_kenh_phan_phoi = (isset($data['id_kenh_phan_phoi'])) ? $data['id_kenh_phan_phoi'] : null;
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->kenh_phan_phoi = (isset($data['kenh_phan_phoi'])) ? $data['kenh_phan_phoi'] : null;
        $this->chiet_khau = (isset($data['chiet_khau'])) ? $data['chiet_khau'] : null;
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdKenhPhanPhoi($id_kenh_phan_phoi)
    {
        $this->id_kenh_phan_phoi=$id_kenh_phan_phoi;
    }

    public function getIdKenhPhanPhoi()
    {
        return $this->id_kenh_phan_phoi;
    }

    public function setIdKho($id_kho)
    {
        $this->id_kho=$id_kho;
    }

    public function getIdKho()
    {
        return $this->id_kho;
    }

    public function setKenhPhanPhoi($kenh_phan_phoi)
    {
        $this->kenh_phan_phoi=$kenh_phan_phoi;
    }

    public function getKenhPhanPhoi()
    {
        return $this->kenh_phan_phoi;
    }

    public function setChietKhau($chiet_khau)
    {
        $this->chiet_khau=$chiet_khau;
    }

    public function getChietKhau()
    {
        return $this->chiet_khau;
    }

    
    
}
