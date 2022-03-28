<?php namespace Nidrax69\YousignApiLaravel;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
class YousignApiLaravel {

    protected $baseUrl;
    protected $baseUrlWithoutSlash;
    protected $apikey;

    protected $_procedure = array(
        'name' => '',
        'description' => '',
        'start' => false,
        'expiresAt' => null,
        'template' => false,
        'ordered' => false, 
        'metadata' => [],
        'config' => array(),
        'archive' => false
    );

    protected $_webhook = array(

    );

    // default content SMS
    protected $_operationModeSmsConfig = array(
        "content" => "SIGNATURE ELECTRONIQUE : {{code}} est votre code de sécurité pour confirmer la signature de vos documents."
    );

    public function __construct() {
        $this->setApikey(env('YOUSIGN_KEY'));
        $this->apiBaseUrl = env('YOUSIGN_API_URL');
        $this->baseUrlWithoutSlash = substr(env('YOUSIGN_API_URL'), 0, -1);;
    }

    /**
     * Set API KEY from Yousign
     * @param $apikey
     */
    private function setApikey($apikey) {
        $this->apikey = $apikey;
    }

    /**
     * Set procedure key/value 
     * 
     * @param $apikey
     */

    public function setProcedureKeyValue($key, $value) {
        $this->_procedure[$key] = $value;
    }

    /**
     * Set webhook value 
     * 
     * @param $apikey
     */

    private function setWebhook($key, $value) {
        $this->_webhook[$key] = $value;
    }

    /**
     * Set add SMS Content  
     * 
     * @param $apikey
     */

    public function addSmsContent($value) {
        $this->_operationModeSmsConfig['content'] = $value;
    }

    /**
     * get numPage from a pdf file
     */

    public function getNumPagesInPDF($file)
    {
        $file_headers = @get_headers($file);
        if ($file_headers[0] == 'HTTP/1.1 404 Not Found') return null;
        if (!$fp = @fopen($file, "r")) return null;
        $max = 0;
        while (!feof($fp)) {
            $line = fgets($fp, 255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                preg_match('/[0-9]+/', $matches[0], $matches2);
                if ($max < $matches2[0]) $max = $matches2[0];
            }
        }
        fclose($fp);
        return (int)$max;
    }

    /**
     * Set add Webhook  
     * 
     * @param $apikey
     */

    public function addWebhook($type, $url, $method, $headers = []) {
        $webhook = array(
            array(
                "url" => $url,
                "method" => $method,
                "headers" => $headers
            )
        );
        $this->setWebhook($type, $webhook);
    }

    /**
     * @return mixed
     */
    public function getApikey() {
        return $this->apikey;
    }

    public function api_request($path, $method, $params = [], $removeSlash = false, $asBody = false)
    {
        if ($removeSlash) {
            $baseUrl = $this->baseUrlWithoutSlash;
        } else {
            $baseUrl = $this->apiBaseUrl;
        }
        $response = Http::withOptions(['debug' => false])->withToken($this->getApikey())->$method($baseUrl . $path, $params);

        try {
            if ($asBody) {
                return $response->throw()->body();
            } else {
                return $response->throw()->json();
            }
        } catch (RequestException $e) {
            abort($response->status(), $response->body(), ['Content-Type: application/json']);
        }
        
    }

    /**
     * @parms
     * @return mixed
     */

    public function createProcedure() {
        $method = 'POST';
        $path = 'procedures';

        $this->_procedure['config']['webhook'] = $this->_webhook;
        return $this->api_request($path, $method, $this->_procedure);
    }

    /**
     * @params 
     * @return mixed
     */

    public function getProcedure($procedureId) {
        $method = 'GET';
        $path = 'procedures';

        $this->api_request($path . '/' . $procedureId, $method);
    }

    /**
     * @params name string name of the file
     * @params content string s3Filename
     * @params procedureId string the procedure id from yousign
     * @params isAttachment boolean if the file is only readonly not for a signature
     * @return mixed
     */

    public function addFile($name, $content, $procedureId = null, $isAttachment = false) {
        $method = 'POST';
        $path = 'files';

        $data = file_get_contents($content);
        $b64Doc = base64_encode($data);

        $parameters = array(
            'name' => $name,
            'content' => $b64Doc,
            'procedure' => $procedureId, 
            'type' => $isAttachment ? 'attachment' : 'signable'
        );
        return $this->api_request($path, $method, $parameters);
    }

    /**
     * @params firstname string
     * @params lastname string
     * @params email string
     * @params phone string
     * @params procedureId string
     * @params type string (default = 'signer') other 'validator'
     * @params position integer To determine the position of the signer for ordered procedure see https://dev.yousign.com/#dfe29009-0f87-41d4-a16d-3dbbb7e9c1db
     * 
     * @return mixed
     */

    public function addMember($firstname, $lastname, $email, $phone, $procedureId = null, $type = "signer", $position = null) {
        $method = 'POST';
        $path = 'members';

        $member = array(
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $email,
            "phone" => $phone,
            "procedure" => $procedureId,
            "type" => $type,
            "operationLevel" => "custom",
            "operationModeSmsConfig" => $this->_operationModeSmsConfig,
        );

        if (!is_null($position)) {
            $member["position"] = $position;
        }

        return $this->api_request($path, $method, $member);
    }

    /**
     * @params fileId string
     * @params memberId string
     * @params position string positionning signature see https://placeit.yousign.fr/
     * @params reason string see https://dev.yousign.com/#ba613ed7-08fa-45ea-9b5f-5e850aa367dc
     * @params procedureId string
     * @params page int num page where to put the signature
     * @params type int (2 types of fields: signature (default value) or text which will be used for text fields.)
     * @params contentRequired bool see https://dev.yousign.com/#3e7c6772-e92a-4b3d-98d0-84c22a64f3d7
     * @params content string|null see https://dev.yousign.com/#3e7c6772-e92a-4b3d-98d0-84c22a64f3d7
     * @params mention1 string
     * @params mention2 string
     * 
     * @return mixed
     */

    public function addFileObject($fileId, $memberId, $position, $reason, $page, $type = 'signature', $contentRequired = true, $content = null, $mention = null, $mention2 = null) {
        $method = 'POST';
        $path = 'file_objects';

        $parameter = array(
            "file" => $fileId,
            "member" => $memberId,
            "position" => $position,
            "page" => $page,
            "mention" => $mention,
            "mention2" => $mention2,
            "reason" => $reason,
            "content" => $content,
            "contentRequired" => $contentRequired,
        );

        return $this->api_request($path, $method, $parameter);
    }

    /**
     *  used for start the procedure and get signature list
     * 
     */
    
    public function launchProcedure($procedureId) {
        $method = 'PUT';
        
        $parameter = array(
            'start' => true
        );

        // remove slash because the id is /procedure/id-XXXXXXXX
        return $this->api_request($procedureId, $method, $parameter, true);
    }

    /**
     *  Consumption
     */
    
    public function consumption() {
        $method = 'PUT';
        $path = 'consumptions/metrics';

        return $this->api_request($path, $method);
    }

    /**
     *  getFileSigned
     */
    
    public function fileSigned($fileId, $binaryMode = true) {
        $method = 'GET';

        if ($binaryMode) {
            $path =  $fileId . "/download?alt=media";
        } else{
            $path =  $fileId . "/download";
        }

        return $this->api_request($path, $method, [], true, true);
    }

}
