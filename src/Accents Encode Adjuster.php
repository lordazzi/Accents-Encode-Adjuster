<?php

/**
	This function will return if the string is or isn't utf-8, if you wanna
	know if the file is utf-8 you must pass an sample of the file, like: isUtf8("á");
	
	Essa função vai retornar se a string é ou não utf-8, se você deseja
	saber se o arquivo é utf-8 você deve passar uma amostra do arquivo, dessa forma: isUtf8("á");
*/
function isUtf8($string) {
	$enc = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1'); // if the last letter to be an accent, this will every returns utf-8
	return ($enc == "UTF-8") ? (TRUE) : (FALSE);
}

/**
	Force the string becomes utf-8, if it is ISO-8859-1 this will be encoded else
	if this will just return the value
	
	Força a string se tornar utf-8, se ela for ISO-8859-1 ela será codificada se não
	o valor será apenas retornado
*/
function encode($string) {
	$enc = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	return ($enc == "ISO-8859-1") ? (utf8_encode($string)) : ($string);
}

/**
	Same from the encode function, but this will every return the string as ISO-8859-1
	
	A mesma coisa que a função encode(), mas essa vai sempre retornar a string como ISO-8859-1
*/
function decode($string) {
	$enc = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	return ($enc == "UTF-8") ? (utf8_decode($string)) : ($string);
}

/**
	When you're using json_encode() the strings inside the array must be encoded in
	UTF-8 so, if one of your programmers are just don't use the right encode for the
	files or if the information comes from outside (like rss or another xml) you can
	create a function based on this encode_array() that does this:
			echo json_encode(encode_array($arr)); exit();
			
	Quando você está utilizando json_encode() a string dentro do array deve estar encodada
	em UTF-8 então, se algum dos seus programadores não estão utilizando o encode correto
	nos arquivos ou se a informação que você tem está vindo de fora (como um rss ou outro
	tipo de xml) você pode criar um função baseada na encode_array() que seria assim:
			echo json_encode(encode_array($arr)); exit();
	
*/
function encode_array($arr) {
	foreach ($arr as &$ar) {
		if (gettype($ar) == "array") {
			$ar = encode_array($ar);
		} else if (gettype($ar) == "string") {
			$ar = encode($ar);
		}
	}
	return $arr;
}

/**
	Same from utf-8 array_encode, but for ISO-8859-1... rarely used, maybe can be used
	for things like send mail or sms
	
	A mesma coisa que a função que codifica um array para utf-8, mas faz isso para ISO-8859-1...
	será raramente usado, talvéz você utilize em coisas relacionadas à informações enviadas via email ou sms
*/
function decode_array($arr) {
	foreach ($arr as &$ar) {
		if (gettype($ar) == "array") {
			$ar = decode_array($ar);
		} else if (gettype($ar) == "string") {
			$ar = decode($ar);
		}
	}
	return $arr;
}

/**
	This function will revert the most errors of encoding with accents, these
	errors are communal for websites that use international that receive information
	from people from Brazil, or another country where accents are used.
	
	This function not just work with encode, but with informations that cross various
	encodes and become deformed
	If the word is 'São Paulo' but when display on the page becomes 'SÃ£o Paulo',
	or 'SÃƒÂ£o Paulo' or 'S<?>o Paulo', this function will return 'São Paulo'
	
	There is some extreme cases where the information crossed so much encodes that the information
	about the accent was lost, and become like this: 'S?o Paulo' or 'SÁ?o Paulo'
	
	This function will work only with deformities caused by utf8
	
	The function is considering that you're using <meta charset="utf-8" /> in your html head,
	if you're not using, you must put FALSE in second parameter
	----
	
	Essa função vai reverter a maior parte dos erros de codificação com acentos, esses
	erros são comuns nos sites brasileiros e nos paises onde acentos são usados.
	
	Essa função não trabalha apenas com o encode, mas com informações que cruzaram por
	varias codificações e ficaram deformadas
	Se você tiver a palavra 'São Paulo' mas quando é exibida na página fica 'SÃ£o Paulo',
	ou 'SÃƒÂ£o Paulo', ou ainda 'S<?>o Paulo', essa função fará com que o retorno seja 'São Paulo'
	
	Há apenas alguns casos extremos onde a informação cruzou um número tão grande de encodes
	que a informações à respeito do acento se perde, como por exemplo: 'S?o Paulo' ou 'SÁ?o Paulo'
	
	Essa função irá funcionar apenas com deformidades causados por utf8
	
	Essa função está considerando que você esteja utilizando <meta charset="utf-8"> no cabeçalho
	de seu html, caso você não esteja utilizando, você deve passar o segundo parâmetro como FALSE
*/
function html_encode($string, $html_utf8 = TRUE) {
	echo $string." to ";
	$exessive_decode = "/(Ãƒâ‚¬)|(ÃƒÂ)|(ÃƒÆ’)|(Ãƒâ€š)|(Ãƒâ€ž)|(Ãƒâ€°)|(ÃƒË†)|(ÃƒÅ )|(Ãƒâ€¹)|(ÃƒÂ)|(ÃƒÅ’)|(ÃƒÅ½)|(ÃƒÂ)|(Ãƒâ€)|(Ãƒâ€¢)|(Ãƒâ€œ)|(Ãƒâ€™)|(Ãƒâ€“)|(ÃƒÅ“)|(ÃƒÅ¡)|(Ãƒâ„¢)|(Ãƒâ€º)|(Ãƒâ€¡)|(Ãƒâ€˜)|(ÃƒÂ )|(ÃƒÂ¡)|(ÃƒÂ£)|(ÃƒÂ¢)|(ÃƒÂ¤)|(ÃƒÂ©)|(ÃƒÂ¨)|(ÃƒÂª)|(ÃƒÂ«)|(ÃƒÂ­)|(ÃƒÂ¬)|(ÃƒÂ®)|(ÃƒÂ¯)|(ÃƒÂ´)|(ÃƒÂµ)|(ÃƒÂ³)|(ÃƒÂ²)|(ÃƒÂ¶)|(ÃƒÂ¼)|(ÃƒÂº)|(ÃƒÂ¹)|(ÃƒÂ»)|(ÃƒÂ§)|(ÃƒÂ±)/";
	$decoded = "/(Ã€)|(Ã)|(Ãƒ)|(Ã‚)|(Ã„)|(Ã‰)|(Ãˆ)|(ÃŠ)|(Ã‹)|(Ã)|(ÃŒ)|(ÃŽ)|(Ã)|(Ã”)|(Ã•)|(Ã“)|(Ã’)|(Ã–)|(Ãœ)|(Ãš)|(Ã™)|(Ã›)|(Ã‡)|(Ã‘)|(Ã )|(Ã¡)|(Ã£)|(Ã¢)|(Ã¤)|(Ã©)|(Ã¨)|(Ãª)|(Ã«)|(Ã­)|(Ã¬)|(Ã®)|(Ã¯)|(Ã´)|(Ãµ)|(Ã³)|(Ã²)|(Ã¶)|(Ã¼)|(Ãº)|(Ã¹)|(Ã»)|(Ã§)|(Ã±)/";
	$neutral = "/(À)|(Á)|(Ã)|(Â)|(Ä)|(É)|(È)|(Ê)|(Ë)|(Í)|(Ì)|(Î)|(Ï)|(Ô)|(Õ)|(Ó)|(Ò)|(Ö)|(Ü)|(Ú)|(Ù)|(Û)|(Ç)|(Ñ)|(à)|(á)|(ã)|(â)|(ä)|(é)|(è)|(ê)|(ë)|(í)|(ì)|(î)|(ï)|(ô)|(õ)|(ó)|(ò)|(ö)|(ü)|(ú)|(ù)|(û)|(ç)|(ñ)/";
	$encoded = "/(\xC0)|(\xC1)|(\xC3)|(\xC2)|(\xC4)|(\xC9)|(\xC8)|(\xCA)|(\xCB)|(\xCD)|(\xCC)|(\xCE)|(\xCF)|(\xD4)|(\xD5)|(\xD3)|(\xD2)|(\xD6)|(\xDC)|(\xDA)|(\xD9)|(\xDB)|(\xC7)|(\xD1)|(\xE0)|(\xE1)|(\xE3)|(\xE2)|(\xE4)|(\xE9)|(\xE8)|(\xEA)|(\xEB)|(\xED)|(\xEC)|(\xEE)|(\xEF)|(\xF4)|(\xF5)|(\xF3)|(\xF2)|(\xF6)|(\xFC)|(\xFA)|(\xF9)|(\xFB)|(\xE7)|(\xF1)/";
		
	if (!isUtf8("á") and $html_utf8) {
		$decoded = utf8_encode($decoded);
		$neutral = utf8_encode($neutral);
	}

	if (isUtf8("á") AND $html_utf8) {
		if (preg_match($decoded, $string)) {
			return utf8_decode($string);
		} else if (preg_match($encoded, $string) and !isUtf8($string)) {
			return utf8_encode($string);
		} else {
			return $string;
		}
	} else if (!isUtf8("á") AND $html_utf8) {
		if (preg_match($decoded, $string)) {
			return utf8_decode($string);
		} else if (preg_match($neutral, $string)) {
			return $string;
		} else if (preg_match($encoded, $string)) {
			return utf8_encode($string);
		} else {
			return $string;
		}
	} else if (isUtf8("á") AND !$html_utf8) {
		if (preg_match($exessive_decode, $string)) {
			return utf8_decode(utf8_decode(utf8_decode($string)));
		} else if (preg_match($decoded, $string)) {
			return utf8_decode(utf8_decode($string));
		} else if (preg_match(utf8_encode($encoded), $string)) {
			return utf8_decode($string);
		} else if (preg_match($neutral, $string)) {
			return utf8_decode($string);
		} else {
			return $string;
		}
	} else if (!isUtf8("á") AND !$html_utf8) {
		if (preg_match($exessive_decode, $string)) {
			return utf8_decode(utf8_decode($string));
		} else if (preg_match($decoded, $string)) {
			return utf8_decode($string);
		} else {
			return $string;
		}
	}
}

/**
	The same function that html_encode(), but for sql
	The cool in this class is the datetime: it return as timestamp, every 8D
	
	A mesma função que html_encode(), mas para sql
	O maneiro desta classe é o datetime: ele retorna como timestamp, sempre 8D
*/
function sql_encode($string) {
	return utf8_decode(html_encode($string));
}

/**
	This is not just an sample of how you can use my functions, but this is too an bonus class.
	This will control internally the addslashes, stripslashes and encode problem
	
	Esse não só é um exemplo de como usar as minhas funções, mas também é uma classe bônus.
	Ela vai controlar internamente o addslashes, stripslashes e o problem de encode
*/
class MySql {
	private $conn;
	private $first_execution = TRUE;
	
	/**
		When you create a new MySql object, this will require the database to create
		the connection, like: $sql = new MySql("my_database");
		
		Quando você croar um novo objeto MySql, ele vai requerir um banco de dados para
		criar a conexão, por exemplo: $sql = new MySql("meu_banco_de_dados");
	*/
	public function __construct($bd) {
		$this->openConnection($bd);
	}
	
	/**
		This will make the class close the connection with the database when the php file
		finishes or when the object to be unset
		
		Isso vai fazer com que a classe encerre a conexão com o banco de dados quando o
		arquivo php for concluido ou quando o objeto for deletado
	*/
	public function __destruct() {
		return $this->closeConnection();
	}
	
	/**
		If you want to change the database, like: $sql->Conn("my_other_database");
		
		Se você desejar trocar o banco de dados, por exemplo: $sql->Conn("meu_outro_banco_de_dados");
	*/
	public function Conn($bd) {
		$this->closeConnection();
		$this->openConnection($bd);
	}
	
	/**
		Here you must put your sql informations, you know...
		
		Aqui você deve colocar as infromações do seu sql, você sabe...
	*/
	private function openConnection($bd) {
		$this->conn = mysqli_connect(SERVER, USER, PASSWORD, $bd);
	}
	
	private function closeConnection() {
		return mysqli_close($this->conn);
	}
	
	/**
		Through this method you can execute any query to your sql (and you will maintain
		the connection until php finishes), this method is not recommended to use because
		if you do that the class will not treat each information that is passed to sql...
		use the Call() method
		Sample: $sql->Query("SELECT * FROM my_cool_table");
		
		Note: if you're selecting only one register on the table, you can pass TRUE on second
		parameter and will not return an array with one register, but only one register 8D
		---
		
		Através deste método você poderá executar qualquer comando sql (e você irá manter
		a mesma conexão até que o php encerre), este método não é recomendado de ser utilizado
		porque se você fizer isso a classe não irá tratar cada informação que for passada para
		o sql... utilize o método Call()
		Exemplo: $sql->Query("SELECT * FROM minha_tabela_maneira");
		
		Observação: se você estiver selecionando apenas um registro na tabela, você deve passar
		o segundo parâmetro como TRUE e então não irá retornar um array com um único registro, mas
		apenas o único registro 8D
	*/
	public function Query($query, $onlyone = FALSE) {
		$datas = mysqli_query($this->conn, $query);
		
		if (gettype($datas) == "object") {
			$fields = array();
			$finfo = $datas->fetch_fields();
			
			foreach($finfo as $val) {
				$fields[] = array(
					"fieldname" => $val->name,
					"type" => $val->type,
					"length" => $val->max_length
				);
			}
			
			$i = 0;
			$record = array();
			while ($data = $datas->fetch_array()) {
				$record[$i] = array();
				
				foreach ($fields as $f) {
					if (!is_numeric($f['fieldname'])) {
						switch ($f["type"]) {
							case 3:
							case 8:
								$record[$i][$f['fieldname']] = (int) $data[$f['fieldname']];
								break;
							case 1:
							case 16:
								$record[$i][$f['fieldname']] = (bool) $data[$f['fieldname']];
								break;
							case 12:
							case 10:
							case 9:
							case 8:
							case 7:
								$record[$i][$f['fieldname']] = (int) strtotime($data[$f['fieldname']]);
								break;
							case 246:
							case 4:
								$record[$i][$f['fieldname']] = (float) $data[$f['fieldname']];
								break;
							case 11: //hora
								$record[$i][$f['fieldname']] = encode($data[$f['fieldname']]);
								break;
							case 252: //	text
							case 253: //	string
							default:
								$record[$i][$f['fieldname']] = stripslashes(encode($data[$f['fieldname']]));
							break;
						}
					}
				}
				$i++;
			}
			
			if ($onlyone) {
				return $record[0];
			} else {
				return $record;
			}
		} else {
			return array();
		}
	}
	
	/**
		This method will adjust each information that was passed for sql,
		this will not convert timestamp to YYYY-MM-DD, don't wait for magics...
		but this will treat the encode and use addslashes for string...
		Samples:
		
		Procedure to send information:
		$sql->Call("my_cool_procedure", array(
			(int) $_POST["number"], $_POST["string"], NULL
		));
		
		Procedure to get only one register:
		$sql->Call("get_onlyone_register", TRUE);
		
		Procedure that send information and return an id:
		$sql->Call("any_procedure", array(
			"intserme", "saveme", "databaseme"
		), TRUE);
		------------
		
		Esse método vai ajustar cada informação que for passado para o sql,
		ele não vai converter timestyamp para YYYY-MM-DD, não espere por mágicas...
		mas ele irá tratar o encode e utilizar addslashes para strings....
		Exemplos:
		
		Procedure que envia informações para o banco de dados:
		$sql->Call("minha_procedure_maneira", array(
			(int) $_POST["numero"], $_POST["coisas"], NULL
		));
		
		Procedure que deve retornar apenas um registro:
		$sql->Call("retorne_um_registro", TRUE);
		
		Procedure que envia informação para o banco e retorna apenas o id:
		$sql->Call("qualquer_procedure", array(
			"insirame", "mesalve"
		), TRUE);
	*/
	public function Call($procedure, $values = array(), $isonlyone = FALSE) {		
		if (!$this->first_execution) {
			mysqli_query($this->conn, "GO");
		}
		$this->first_execution = FALSE;
		
		$isonlyone = ($values === TRUE) ? (TRUE) : ($isonlyone);
		if (is_array($values) AND count($values) <> 0) {
			foreach ($values as &$value) {
				if (is_string($value)) {
					$value = "'".sql_encode(trim(addslashes($value)))."'";
				} else if (is_float($value)) {
					$value = str_replace(",", ".", (string) $value);
				} else if (is_bool($value)) {
					$value = ($value) ? (1) : (0);
				} else if (is_null($value)) {
					$value = "NULL";
				}
			}
		}
		
		/**
			Here you can call a procedure for a log where the file and procedure
			that was used will be save, with this, you gonna know where each
			procedure is used and if this keep used:
			
			$this->Query("call sp_log_procedure_save('$procedure', '$_SERVER[PHP_SELF]'); GO");
			
			Aqui você pode chamar uma procedure para um log onde o arquivo e a
			procedure que foi usava serão salvos, com isso, você irá saber onde
			cada procedure está sendo utilizanda e se ela ainda é utilizada:
			
			$this->Query("call sp_log_procedure_save('$procedure', '$_SERVER[PHP_SELF]'); GO");
		*/
		
		return $this->Query("call $procedure(".implode(", ", $values).");", $isonlyone);
	}
	
	public function lastId() {
		return mysqli_insert_id($this->conn);
	}
}

echo "WHEN <strong>META TAG</strong> IS UTF-8<br />";
echo html_encode(utf8_decode("São Paulo"))."<br />";
echo html_encode(utf8_encode("São Paulo"))."<br />";
echo html_encode(utf8_encode(utf8_encode("São Paulo")))."<br />";
echo html_encode("São Paulo")."<br />";

echo "<br />WHEN IT IS ISO-8859-1<br />";
echo html_encode(utf8_decode("São Paulo"), 0)."<br />";
echo html_encode(utf8_encode("São Paulo"), 0)."<br />";
echo html_encode(utf8_encode(utf8_encode("São Paulo")), 0)."<br />";
echo html_encode("São Paulo", 0)."<br />";
?>