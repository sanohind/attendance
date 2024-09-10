<?php
class Config
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function getConfig($cfgName)
    {
        $sql = $this->db->prepare("select * from config where cfgName = ?");
        $sql->bindValue(1, $cfgName);
        try {
            $sql->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function storeConfig($cfgName, $cfgValue, $cfgDate,$cfgExpire)
    {
        $sql =  $this->db->prepare("insert into config (cfgName,cfgValue,cfgDate,cfgExpire) values (?,?,?,?)");
        try {
            $sql->execute([
                $cfgName,
                $cfgValue,
                $cfgDate,
                $cfgExpire
            ]);
            return TRUE;
        } catch (Exception $e) {
            die();
            return $e->getMessage();
        }
    }

    public function updateConfig($cfgValue, $cfgDate, $cfgExpire, $cfgName)
    {
        $sql = $this->db->prepare("update config set
                cfgValue = ?,
                cfgDate = ?,
                cfgExpire = ?
                where cfgName = ?");
        try {
            $sql->execute([$cfgValue, $cfgDate, $cfgExpire, $cfgName]);
            return TRUE;
        } catch (Exception $e) {
            return die($e->getMessage());
        }
    }
}
