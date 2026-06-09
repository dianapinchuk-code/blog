<?php

namespace App\Jobs\GenerateCatalog;

class GenerateCatalogMainJob extends AbstractJob
{
    public function handle()
    {
        $this->debug('start');

        // Виконуємо кешування негайно (синхронно)
        GenerateCatalogCacheJob::dispatchSync();

        // Формуємо список задач
        $chain = array_merge(
            $this->getChainPrices(),
            [
                new GenerateCategoriesJob,
                new GenerateDeliveriesJob,
                new GeneratePointsJob,
                new ArchiveUploadsJob,
                new SendPriceRequestJob,
            ]
        );

        // Запускаємо ланцюжок через GenerateGoodsFileJob
        GenerateGoodsFileJob::withChain($chain)->dispatch();

        $this->debug('finish');
    }

    private function getChainPrices()
    {
        $result = [];
        $products = collect([1, 2, 3, 4, 5]);
        $fileNum = 1;

        foreach ($products->chunk(1) as $chunk) {
            $result[] = new GeneratePricesFileChunkJob($chunk, $fileNum);
            $fileNum++;
        }
        return $result;
    }
}
