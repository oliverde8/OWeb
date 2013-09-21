<?php

namespace Extension\user\connection\MozillaPersona;

/**
 * Description of Personna
 *
 * @author oliverde8
 */
class Persona
{
    /**
     * Scheme, hostname and port
     */
    protected $audience;

    /**
     * Constructs a new Persona (optionally specifying the audience)
     */
    public function __construct($audience = NULL)
    {
        $this->audience = $audience ?: $this->guessAudience();
    }

    /**
     * Verify the validity of the assertion received from the user
     *
     * @param string $assertion The assertion as received from the login dialog
     * @return object The response from the Persona online verifier
     */
    public function verifyAssertion($assertion)
    {

        /*$url = 'https://verifier.login.persona.org/verify';
        $data = 'assertion='.$assertion.'&audience=http://persona.localhost:80';

        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => $data
            ),
            'ssl' => array(
                'verify_peer' => true,
                'verify_host' => true
            )
        );
        $context = stream_context_create($params);
        $result = file_get_contents($url, false, $context);

        return $result;*/

        $postdata = 'assertion=' . urlencode($assertion) . '&audience='.$this->guessAudience();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://verifier.login.persona.org/verify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
        curl_close($ch);



        return json_decode($response);
    }

    /**
     * Guesses the audience from the web server configuration
     */
    protected function guessAudience()
    {
        $audience = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $audience .= $_SERVER['SERVER_NAME'] . ':'.$_SERVER['SERVER_PORT'];
        return $audience;
    }
}

?>
