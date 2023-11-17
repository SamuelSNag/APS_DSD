<?php
	$cidade = "";
	$cidade = $_GET['cidade'];

	$base = '{"results":{"temp":0,"date":"--/--/--","time":"--:--","condition_code":"27","description":"----","currently":"dia","cid":"","city":"==Limite de consultas excedido!!==","img_id":"27","humidity":0,"cloudiness":0,"rain":0,"wind_speedy":"-- km/h","wind_direction":0,"wind_cardinal":"--","sunrise":"--:-- am","sunset":"--:-- pm","moon_phase":"waxing_crescent","condition_slug":"clear_day","city_name":"--","timezone":"-03:00","forecast":[{"date":"--/--","weekday":"Seg","max":0,"min":0,"cloudiness":0,"rain":0,"rain_probability":0,"wind_speedy":"-- km/h","description":"-----","condition":"cloudly_day"}]}}';	

	$CID = "São Paulo-455827,Guarulhos-455867,Campinas-455828,São Bernardo do Campo-449648,Santo André-449145,Osasco-455894,Sorocaba-455913,Ribeirão Preto-455903,São José dos Campos-455912,Mauá-455884,São José do Rio Preto-455911,Santos-455991,Carapicuíba-428495,Bauru-455845,Itaquaquecetuba-455962,Franca-455863,Barueri-424228,Taubaté-455915,Suzano-452779,Limeira-455879,Guarujá-455952,Sumaré-452723,Cotia-456160,Indaiatuba-459661,Araraquara-455930,Jacareí-455871,Marília-455882,Americana-455837,Hortolândia-435210,Itapevi-455961";

	$lista = explode(",", $CID);
	$cidadesID = [];
	$cidades = [];

	foreach($lista as $s){
		array_push($cidadesID, explode("-",$s));
		array_push($cidades, explode("-",$s)[0]);
	}
	if($cidade == "obter_cidades"){
		echo "{".'"cidades":[';
		$linha = "";
		foreach ($cidades as $nome) {
			$linha = $linha.'"'.$nome.'"'.",";
		}
		$linha = substr($linha, 0, strlen($linha)-1);
		echo $linha."]}";

	} else {
		$id = 455827;
		if(in_array($cidade, $cidades)){
			$id = $cidadesID[array_search($cidade, $cidades)][1];
		}
		$url = "https://api.hgbrasil.com/weather?key=5a6cff95&woeid=".$id;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$resposta = curl_exec($curl);
		curl_close($curl);

		$txt = "{".substr($resposta, strpos($resposta, '"results"'), strpos($resposta, ',"cref"')-strpos($resposta, '"results"'))."}}";
		
        if (substr($txt, 15, 5) == "error"){
            echo $base;
        } else {
           echo $txt; 
        }
	}
?>