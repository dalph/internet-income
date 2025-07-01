<?php

declare(strict_types = 1);

namespace frontend\controllers;

use common\services\ReferralLinkService;
use Yii;
use yii\web\Controller;

/**
 * Контроллер для отображения реферальных ссылок
 */
class ReferralLinkController extends Controller
{
    /**
     * Сервис для работы с реферальными ссылками
     *
     * @var ReferralLinkService
     */
    private $referralLinkService;

    /**
     * {@inheritdoc}
     */
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->referralLinkService = new ReferralLinkService();
    }

    /**
     * Список активных реферальных ссылок
     */
    public function actionIndex()
    {
        $links = $this->referralLinkService->getActiveLinks();
        $topLinks = $this->referralLinkService->getTopActiveLinks();

        return $this->render('index', [
            'links' => $links,
            'topLinks' => $topLinks,
        ]);
    }
} 