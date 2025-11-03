<?php

namespace Delta\Components\Http\Enums;


enum HttpRequestHeader: string
{
    case METHOD = "REQUEST_METHOD";

    case PATH = "REQUEST_URI";

    case ROUTE = "PHP_SELF";

    case IP = "REMOTE_ADDR";

    case PROTOCOL = "SERVER_PROTOCOL";

    case DOMAIN = "SERVER_NAME";

    case QUERY = "QUERY_STRING";

    case AGENT = "HTTP_USER_AGENT";

    case TIME = "REQUEST_TIME";

    case HOST = "HTTP_HOST";
}