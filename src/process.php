<?php
$errors = array();
$data = array();
$myMetas = array();

/* Grab the webpage source code */
function file_get_contents_curl($url) {
    $ch = curl_init();

	curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");
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
	$html = file_get_contents_curl($url);
	libxml_use_internal_errors(true);
	$doc = new DomDocument();
	$doc->loadHTML($html);
	$xpath = new DOMXPath($doc);
	$query = '//*/meta[starts-with(@property, \'og:\')]';
	$metas = $xpath->query($query);
	foreach ($metas as $meta) {
	    $property = $meta->getAttribute('property');
	    $content = $meta->getAttribute('content');
	    $myMetas[$property] = $content;
	}

	return $myMetas;
}

/* Validate the URL */
if (empty($_POST['url'])) {
	$data['success'] = false;
	$errors['url'] = 'A Url is required.';
} else {
	$data['success'] = true;
	$data['message'] = 'Success!';
	$url = $_POST['url'];
	$data['html'] = array();
	$data['html'] = getMetaTags($url);
}

echo json_encode($data);
?>