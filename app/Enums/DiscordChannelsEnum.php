<?php

namespace App\Enums;

enum DiscordChannelsEnum: string
{
    case BACKEND_ERRORS = 'https://discord.com/api/webhooks/1095712580573609985/NG-MSwal8_mMIEpRihfFn0NdsYjaotBt3BwYy2EbHfz4zjzvMB4dZMdz-vuCa70MX5Le';
    case NEW_USER = 'https://discord.com/api/webhooks/1095762992756432956/XYRvTisuORpto60bRcXq_gb-c7ACCtI3F2QN5ZmSKJRzEIcfRKuKYi1ddPEAs09W5Wni';
    case NEW_AUTHENTICATION = 'https://discord.com/api/webhooks/1095762782470815784/jiY73G42YQEk3jaObd_7jEFG295qQ3xlwwLmLQcyzEc-Bp4X6pgEFlFLsZE7NJdy9KXQ';
    case NEW_ORDER = 'https://discord.com/api/webhooks/1095762708437159936/zZJlLT6n5OzrXb72uO9wROo0xyN5Y9gdJkp19oLEHCVshiEsitXu-eGALMq0kjwKeX7a';
    case NEW_CONTRACT = 'https://discord.com/api/webhooks/1095762596851879986/l3Yz_gVewOoQD1q0lxz17ZQ-MKG0DICfqRtAlGuxzo8N72m8UOtgiSvwZExyHkghspeA';
    case FRONTEND_ERRORS = 'https://discord.com/api/webhooks/1095763072175583272/dA8obuEVr2vfuOn3tYmJvC9wXfsuPdyn59s9LGTEyRodSaHoyJUVdMd_XSEZUONx2oo2';

    case BACKUP = 'https://discord.com/api/webhooks/1102247557238894613/0cXdFmbHfzvb9O2Q--3aFesvhCK_64F3s58KTtRa9k_0LXBOKWKog9Y_avo1aZbm4sw7';
}
