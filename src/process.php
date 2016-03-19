<?php
$errors = array();
$data = array();
$myMetas;

/* Grab the webpage source code */
function file_get_contents_curl($url) {
    $ch = curl_init();

	curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/cacert.pem');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

/* Return OG meta tags */
function getMetaTags($url) {
	$html = file_get_contents($url);
	libxml_use_internal_errors(true);
	$doc = new DomDocument();
	$doc->loadHTML($html);
	$xpath = new DOMXPath($doc);
	$query = '//*/meta[starts-with(@property, \'og:\')]';
	$metas = $xpath->query($query);
	// print_r($metas);

	if($metas->length != 0) {
		$myMetas = array();
		foreach ($metas as $meta) {
		    $property = $meta->getAttribute('property');
		    $content = $meta->getAttribute('content');
		    $myMetas[$property] = $content;
		}
	} else {
		$myMetas['Warning'] = 'Sorry, couldn\'t find an Open Graph meta tag. Your website may have timed out, or your meta tag format may be incorrect. Use <meta property=""> instead of <meta name="">.';
		// $myMetas = 'Could not find an Open Graph meta tag.';
	}
	// var_dump($myMetas);
	return $myMetas;
}

/* Validate the URL */
if (empty($_POST['url'])) {
	$data['success'] = false;
	$errors['url'] = 'A URL is required.';
} else {
	$url = $_POST['url'];
	if (filter_var($url, FILTER_VALIDATE_URL) === false) {
		$data['success'] = false;
		$errors['url'] = 'Not a valid URL.';
	    // die('Not a valid URL.');
	} else {
		$data['success'] = true;
		$data['message'] = 'Success!';
		$url = $_POST['url'];
		$data['html'] = getMetaTags($url);
	}

}

echo json_encode($data);
?>