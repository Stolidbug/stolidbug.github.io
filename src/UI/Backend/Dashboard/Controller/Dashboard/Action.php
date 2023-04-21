<?php

declare(strict_types=1);

namespace App\UI\Backend\Dashboard\Controller\Dashboard;

use App\Shared\Infrastructure\Responder\HtmlResponder;
use Monofony\Contracts\Admin\Dashboard\DashboardStatisticsProviderInterface;
use Symfony\Component\HttpFoundation\Response;

final class Action
{
    public function __construct(
        private readonly DashboardStatisticsProviderInterface $statisticsProvider,
        private readonly HtmlResponder $htmlResponder,
    ) {
    }

    public function __invoke(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();

        return ($this->htmlResponder)('backend/index', [
            'statistics' => $statistics,
        ]);
    }
}
