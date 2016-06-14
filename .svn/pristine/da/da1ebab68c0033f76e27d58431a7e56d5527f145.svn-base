<?PHP
    $path = isset($_GET['path']) ? $_GET['path'] : "";
    $type = isset($_GET['type']) ? $_GET['type'] : ".xml";
    $name = isset($_GET['name']) ? $_GET['name'] : "";
    
    $list = "";
    
    if ($path && file_exists($path))
    {
        try 
        {
            $dirs = scandir($path);
                
            for ($f=0;$f<count($dirs);$f++)
            { 
                // nur die Dateien des vorgegebenen Typs (Dateiendung) berücksichtigen
                if ($dirs[$f] != "." && $dirs[$f] != ".." && stripos($dirs[$f],$type) !== false)
                {
                    // keine Verzeichnisse berücksichtigen
                    $checkFile = str_replace("\\\\","\\",$path."\\".$dirs[$f]);
                    
                    if (is_file($checkFile))
                    {
                        // sollen nur bestimmte Namen berücksichtigt werden?
                        if ($name != "")
                        {
                            if (stripos($dirs[$f],$name) !== false)
                                $list .= '    <option value="'.$checkFile.'">'.$dirs[$f].'</option>';
                        }
                        else
                            $list .= '    <option value="'.$checkFile.'">'.$dirs[$f].'</option>';
                    }
                }
            }
           
        }
        catch (Exception $e)
        {
            $list = "<option>Fehler: ".$e->getMessage()."</option>";
        }
      
    }    
    echo $list;
?>
    