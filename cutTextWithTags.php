/**
     * @name cutTextWithTags
     * @description recorta un texto respetando las etiquetas  
     * @author  Isai rivas 
     * @param type String $texto
     * @param type Int $longitud
     * @return string
     */
    public static function cutTextWithTags($texto, $longitud = 180) {
        
        if(empty($texto) ){ return $texto; }
        
        if(!filter_var($longitud,FILTER_VALIDATE_INT) ){
            throw new Exception('La longitud es invalida, debe ser un numero entero');
        }
        
        if ( (mb_strlen($texto) > $longitud ) ) {
            $pos_espacios = mb_strpos($texto, ' ', $longitud) - 1;
            if ($pos_espacios > 0) {
                $caracteres = count_chars(mb_substr($texto, 0, ($pos_espacios + 1)), 1);
                if ( isset($caracteres[ord('<')]) && isset($caracteres[ord('>')]) && $caracteres[ord('<')] > $caracteres[ord('>')]) {
                    $pos_espacios = mb_strpos($texto, ">", $pos_espacios) - 1;
                }
                $texto = mb_substr($texto, 0, ($pos_espacios + 1)) . ' ...';
            }
            if (preg_match_all("|(<([\w]+)[^>]*>)|", $texto, $buffer)) {
                if (!empty($buffer[1])) {
                    preg_match_all("|</([a-zA-Z]+)>|", $texto, $buffer2);
                    if (count($buffer[2]) != count($buffer2[1])) {
                        $cierrotags = array_diff($buffer[2], $buffer2[1]);
                        $cierrotags = array_reverse($cierrotags);
                        foreach ($cierrotags as $tag) {
                            $texto .= '</' . $tag . '>';
                        }
                    }
                }
            }
        }
        return $texto;
    }
