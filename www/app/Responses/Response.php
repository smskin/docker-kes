<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 13:28
 */

namespace App\Responses;

class Response
{
    public const CONTINUE = 100; // Underscore is due to continue being a reserved word.
    public const SWITCHING_PROTOCOLS = 101;

    // Successful
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;
    public const NONAUTHORITATIVE_INFORMATION = 203;
    public const NO_CONTENT = 204;
    public const RESET_CONTENT = 205;
    public const PARTIAL_CONTENT = 206;

    // Redirections
    public const MULTIPLE_CHOICES = 300;
    public const MOVED_PERMANENTLY = 301;
    public const FOUND = 302;
    public const SEE_OTHER = 303;
    public const NOT_MODIFIED = 304;
    public const USE_PROXY = 305;
    public const UNUSED= 306;
    public const TEMPORARY_REDIRECT = 307;

    // Client Errors
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED  = 401;
    public const PAYMENT_REQUIRED = 402;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const NOT_ACCEPTABLE = 406;
    public const PROXY_AUTHENTICATION_REQUIRED = 407;
    public const REQUEST_TIMEOUT = 408;
    public const CONFLICT = 409;
    public const GONE = 410;
    public const LENGTH_REQUIRED = 411;
    public const PRECONDITION_FAILED = 412;
    public const REQUEST_ENTITY_TOO_LARGE = 413;
    public const REQUEST_URI_TOO_LONG = 414;
    public const UNSUPPORTED_MEDIA_TYPE = 415;
    public const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    public const EXPECTATION_FAILED = 417;
    public const I_AM_A_TEA_POT = 418; // http://tools.ietf.org/html/rfc2324

    // Server Errors
    public const INTERNAL_SERVER_ERROR = 500;
    public const NOT_IMPLEMENTED = 501;
    public const BAD_GATEWAY = 502;
    public const SERVICE_UNAVAILABLE = 503;
    public const GATEWAY_TIMEOUT = 504;
    public const VERSION_NOT_SUPPORTED = 505;


    /**
     * HTTP Response Code Header Messages, used by statusCode().
     *
     * @author Jarvis Badgley
     */
    private static $messages = array(
        // Informational
        self::CONTINUE=>'100 Continue',
        self::SWITCHING_PROTOCOLS=>'101 Switching Protocols',

        // Successful
        self::OK=>'200 OK',
        self::CREATED=>'201 Created',
        self::ACCEPTED=>'202 Accepted',
        self::NONAUTHORITATIVE_INFORMATION=>'203 Non-Authoritative Information',
        self::NO_CONTENT=>'204 No Content',
        self::RESET_CONTENT=>'205 Reset Content',
        self::PARTIAL_CONTENT=>'206 Partial Content',

        // Redirection
        self::MULTIPLE_CHOICES=>'300 Multiple Choices',
        self::MOVED_PERMANENTLY=>'301 Moved Permanently',
        self::FOUND=>'302 Found',
        self::SEE_OTHER=>'303 See Other',
        self::NOT_MODIFIED=>'304 Not Modified',
        self::USE_PROXY=>'305 Use Proxy',
        self::UNUSED=>'306 (Unused)',
        self::TEMPORARY_REDIRECT=>'307 Temporary Redirect',

        // Client Error
        self::BAD_REQUEST=>'400 Bad Request',
        self::UNAUTHORIZED=>'401 Unauthorized',
        self::PAYMENT_REQUIRED=>'402 Payment Required',
        self::FORBIDDEN=>'403 Forbidden',
        self::NOT_FOUND=>'404 Not Found',
        self::METHOD_NOT_ALLOWED=>'405 Method Not Allowed',
        self::NOT_ACCEPTABLE=>'406 Not Acceptable',
        self::PROXY_AUTHENTICATION_REQUIRED=>'407 Proxy Authentication Required',
        self::REQUEST_TIMEOUT=>'408 Request Timeout',
        self::CONFLICT=>'409 Conflict',
        self::GONE=>'410 Gone',
        self::LENGTH_REQUIRED=>'411 Length Required',
        self::PRECONDITION_FAILED=>'412 Precondition Failed',
        self::REQUEST_ENTITY_TOO_LARGE=>'413 Request Entity Too Large',
        self::REQUEST_URI_TOO_LONG=>'414 Request-URI Too Long',
        self::UNSUPPORTED_MEDIA_TYPE=>'415 Unsupported Media Type',
        self::REQUESTED_RANGE_NOT_SATISFIABLE=>'416 Requested Range Not Satisfiable',
        self::EXPECTATION_FAILED=>'417 Expectation Failed',
        self::I_AM_A_TEA_POT=>'418 I\'m a teapot',

        // Server Error
        self::INTERNAL_SERVER_ERROR=>'500 Internal Server Error',
        self::NOT_IMPLEMENTED=>'501 Not Implemented',
        self::BAD_GATEWAY=>'502 Bad Gateway',
        self::SERVICE_UNAVAILABLE=>'503 Service Unavailable',
        self::GATEWAY_TIMEOUT=>'504 Gateway Timeout',
        self::VERSION_NOT_SUPPORTED=>'505 HTTP Version Not Supported'
    );

    /**
     * @var \stdClass
     */
    protected $data;

    /**
     * @param int $code
     * @return Response
     */
    final public function setCode(int $code): Response
    {
        /** @noinspection GlobalVariableUsageInspection */
        $protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';
        header($protocol. ' ' . static::$messages[$code]);
        return $this;
    }

    final public function json(\stdClass $object): void
    {
        header('Content-type: application/json');
        echo json_encode($object);
        exit();
    }
}