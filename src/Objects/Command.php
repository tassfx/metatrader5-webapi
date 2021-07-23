<?php
namespace CrystalApps\MetaTrader5\Objects;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * Class Command implements a basic command
 * @package CrystalApps\MetaTrader5\Objects
 */
class Command
{
    /**
     * Command path
     * <b>a full-fledged path is used!</b>
     * @var string $path
     */
    public string $path;

    /**
     * Command params
     * @var array
     */
    public array $params;

    /**
     * Default command method
     * @var string
     */
    public string $method;

    public const METHOD_LIST = [
        '/api/order/get','/api/order/get_total','/api/order/get_page','/api/order/get_batch','/api/order/update',
        '/api/order/delete','/api/history/get','/api/history/get_total','/api/history/get_page','/api/history/get_batch',
        '/api/history/update','/api/history/delete','/api/order/backup/list','/api/order/backup/get','/api/order/backup/restore',
        '/api/order/reopen', '/api/deal/get','/api/deal/get_total','/api/deal/get_page','/api/deal/get_batch','/api/deal/update',
        '/api/deal/delete','/api/deal/backup/list','/api/deal/backup/get','/api/deal/backup/restore','/api/position/get',
        '/api/position/get_total','/api/position/get_page','/api/position/get_batch','/api/position/update','/api/position/delete',
        '/api/position/backup/list','/api/position/backup/get','/api/position/backup/restore','/api/position/check','/api/position/fix',
        '/api/trade/balance','/api/trade/calc_rate_buy','/api/trade/calc_rate_sell','/api/trade/check_margin','/api/trade/calc_profit',
        '/api/dealer/send_request','/api/dealer/get_request_result','/api/user/add','/api/user/update','/api/user/delete',
        '/api/user/get','/api/user/get_external','/api/user/get_batch','/api/user/check_password','/api/user/change_password',
        '/api/user/account/get','/api/user/account/get_batch','/api/user/logins','/api/user/total','/api/user/group',
        '/api/user/certificate/update','/api/user/certificate/get','/api/user/certificate/delete','/api/user/certificate/confirm',
        '/api/user/sync_external','/api/user/check_balance','/api/user/archive/add','/api/user/archive/get','/api/user/restore',
        '/api/user/backup/list','/api/user/backup/get','/api/notification/send','/api/client/add','/api/client/update','/api/client/delete',
        '/api/client/get','/api/client/history/get','/api/client/get_ids','/api/client/user/add','/api/client/user/delete',
        '/api/client/user/get_logins','/api/document/add','/api/document/update','/api/document/delete','/api/document/get',
        '/api/document/history/get','/api/comment/add','/api/comment/update','/api/comment/delete','/api/comment/get',
        '/api/attachment/add','/api/attachment/get','/api/attachment/attach','/api/mail/send','/api/mail/get','/api/mail/get_body',
        '/api/news/send','/api/news/get','/api/news/get_body','/api/tick/last','/api/tick/last_group','/api/tick/stat',
        '/api/tick/history','/api/chart/get','/api/book/get','/api/daily_get','/api/daily/get_light','/api/setting/get',
        '/api/setting/set','/api/setting/delete','/api/subscription/join','/api/subscription/cancel','/api/subscription/add',
        '/api/subscription/update','/api/subscription/delete','/api/subscription/get','/api/subscription/exist','/api/subscription/history/add',
        '/api/subscription/history/update','/api/subscription/history/delete','/api/subscription/history/get','/api/common/get','/api/common/set',
        '/api/server/add','/api/server/delete','/api/server/shift','/api/server/total','/api/server/next','/api/server/get','/api/server/restart',
        '/api/tls_certificate/add','/api/tls_certificate/delete','/api/server/shift','/api/server/total','/api/server/next','/api/server/get',
        '/api/server/restart','/api/tls_certificate/add','/api/tls_certificate/delete','/api/tls_certificate/shift','/api/tls_certificate/total',
        '/api/tls_certificate/next','/api/time/server','/api/time/get','/api/time/set','/api/group/add','/api/group/add_batch','/api/group/delete','/api/group/delete',
        '/api/group/delete_batch','/api/group/shift','/api/group/total','/api/group/next','/api/group/get','/api/symbol/add','/api/symbol/add_batch','/symgol_delete',
        '/api/symbol/delete_batch','/api/symbol/shift','/symbold_total','/api/symbol/list','/api/symbol/next','/api/symbol/get','/api/symbol/get_group','/api/firewall/add',
        '/api/firewall/delete','/api/firewall/shift','/api/firewall/total','/api/firewall/next','/api/holiday/add','/api/holiday/delete','/api/holiday/shift','/api/holiday/total','/api/holiday/next',
        '/api/manager/add','/api/manager/delete','/api/manager/shift','/api/manager/total','/api/manager/next','/api/manager/get','/api/route/add','/api/route/delete','/api/route/shift','/api/route/total',
        '/api/route/next','/api/route/get','/api/history_sync/start','/api/history_sync/add','/api/history_sync/delete','/api/history_sync/shift','/api/history_sync/total','/api/history_sync/next','/api/spread/add',
        '/api/spread/delete','/api/spread/shift','/api/spread/total','/api/spread/next','/api/email/add','/api/email/delete','/api/email/shift','/api/email/total','/api/email/next','/api/email/get','/api/email/send',
        '/api/messenger/add','/api/messenger/delete','/api/messenger/shift','/api/messenger/total','/api/messenger/next','/api/messenger/get','/api/messenger/send','/api/gateway/restart','/api/gateway/add',
        '/api/gateway/delete','/api/gateway/shift','/api/gateway/total','/api/gateway/next','/api/gateway/get','/api/gateway/module/total','/api/gateway/module/next','/api/gateway/module/get','/api/gateway/get_position',
        '/api/feeder/restart','/api/feeder/add','/api/feeder/delete','/api/feeder/shift','/api/feeder/total','/api/feeder/next','/api/feeder/get','/api/feeder/module/total','/api/feeder/module/next','/api/feeder/module/get',
        '/api/report/add','/api/report/delete','/api/report/shift','/api/report/total','/api/report/next','/api/report/get','/api/report/module/total','/api/report/module/next','/api/report/module/get',
        '/api/plugin/add','/api/plugin/delete','/api/plugin/shift','/api/plugin/total','/api/plugin/next','/api/plugin/get','/api/plugin/module/total','/api/plugin/module/next','/api/plugin/module/get','/api/subscription/config/add',
        '/api/subscription/config/delete','/api/subscription/config/shift','/api/subscription/config/total','/api/subscription/config/next','/api/subscription/config/get'
    ];

    /**
     * Command constructor.
     * @param string $path
     * @param array $params
     */
    public function __construct(#[ExpectedValues(self::METHOD_LIST)]string $path, array $params = [], #[ExpectedValues(['GET','POST'])]string $method = 'POST')
    {
        $this->params = $params;
        $this->path = $path;
        $this->method = $method;
    }
}