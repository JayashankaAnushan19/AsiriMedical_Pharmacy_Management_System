<?php

define ('HMAC_SHA256', 'sha256');
define ('SECRET_KEY', '16be8b7ed58947f3838bd9e013f860490482f5b01bf24fc4ad83127414602e116cdbce23337749f5917a90368e93db905c4db5c3c0a74352a18a6f79290d0a102e3f6a34b0fc457bb54f35f49fb553be8048ae74dfb246b495a22b4635b57149e7360be54aeb42ffab30c24bc8ae93a83126ee72f97f45f5b2ee9fa1afde056a');

function sign ($params) {
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey) {
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as $field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
    return implode(",",$dataToSign);
}

?>
