<?php
function storageCsvToArray($sPath='',$separador=';')
{
	$path=storage_path($sPath);
	if( file_exists($path) === false ) {
		return false;
	}
	$file=file($path);
	$rows = [];
	$aux1 = str_getcsv( $file[0], $separador, '"' );

	if ( mb_detect_encoding($file[0], 'UTF-8', true) === false ) {
		$keysName = array_map( 'utf8_encode', $aux1 );
	} else {
		$keysName = $aux1;
	}
	foreach ($keysName as $key => $value) {
		$keysName[$key] = str_replace(' ', '_', strtolower($value))	;
	}
	unset($file[0]);
	foreach ($file as $key => $row) {
		$aux2 = str_getcsv( $row, $separador, '"' );
		if ( mb_detect_encoding($row, 'UTF-8', true) === false ) {
			$values = array_map( 'utf8_encode', $aux2 );
		} else {
			$values = $aux2;
		}
		if (count($keysName)===count($values)) {
			$rows[$key] = array_change_key_case(
				array_combine($keysName, $values),
				CASE_LOWER
			);		
		}
	}

	return array_values($rows);
}