<?php
namespace Application\Model\Entity;

class CongNoNhaCungCap
{
    
    protected $id_cong_no;
    protected $id_nha_cung_cap;
    protected $ki;
    protected $no_dau_ki;
    protected $no_phat_sinh;
    protected $du_no;
   
    

    public function exchangeArray($data)
    {
        $this->id_cong_no = (isset($data['id_cong_no'])) ? $data['id_cong_no'] : null;
        $this->id_nha_cung_cap = (isset($data['id_nha_cung_cap'])) ? $data['id_nha_cung_cap'] : null;
        $this->ki = (isset($data['ki'])) ? $data['ki'] : null;
        $this->no_dau_ki = (isset($data['no_dau_ki'])) ? $data['no_dau_ki'] : null;
        $this->no_phat_sinh = (isset($data['no_phat_sinh'])) ? $data['no_phat_sinh'] : null;
        $this->du_no = (isset($data['du_no'])) ? $data['du_no'] : null;
    }    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setIdCongNo($id_cong_no)
    {
        $this->id_cong_no=$id_cong_no;
    }

    public function getIdCongNo()
    {
        return $this->id_cong_no;
    }

    public function setIdNhaCungCap($id_nha_cung_cap)
    {
        $this->id_nha_cung_cap=$id_nha_cung_cap;
    }

    public function getIdNhaCungCap()
    {
        return $this->id_nha_cung_cap;
    }

    public function setKi($ki)
    {
        $this->ki=$ki;
    }

    public function getKi()
    {
        return $this->ki;
    }

    public function setNoDauKi($no_dau_ki)
    {
        $this->no_dau_ki=$no_dau_ki;
    }

    public function getNoDauKi()
    {
        return $this->no_dau_ki;
    }

    public function setNoPhatSinh($no_phat_sinh)
    {
        $this->no_phat_sinh=$no_phat_sinh;
    }

    public function getNoPhatSinh()
    {
        return $this->no_phat_sinh;
    }

    public function setDuNo($du_no)
    {
        $this->du_no=$du_no;
    }

    public function getDuNo()
    {
        return $this->du_no;
    }

    

    
}
