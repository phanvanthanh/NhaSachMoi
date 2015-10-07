<?php
namespace Application\Model\Entity;

class KenhPhanPhoi
{
    
    
    protected $id_kenh_phan_phoi;
    protected $id_kho;
    protected $kenh_phan_phoi;
    protected $chiec_khau;

    public function exchangeArray($data)
    {
        $this->id_kenh_phan_phoi = (isset($data['id_kenh_phan_phoi'])) ? $data['id_kenh_phan_phoi'] : null;
        $this->id_kho = (isset($data['id_kho'])) ? $data['id_kho'] : null;
        $this->kenh_phan_phoi = (isset($data['kenh_phan_phoi'])) ? $data['kenh_phan_phoi'] : null;
        $this->chiec_khau = (isset($data['chiec_khau'])) ? $data['chiec_khau'] : null;
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

    public function setChiecKhau($chiec_khau)
    {
        $this->chiec_khau=$chiec_khau;
    }

    public function getChiecKhau()
    {
        return $this->chiec_khau;
    }

    
    
}
