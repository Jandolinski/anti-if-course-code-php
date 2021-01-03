<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if (!$this->isAgedBrie($item) and !$this->isBackstagePass($item)) {
                if ($item->quality > 0) {
                    if (!$this->isSulfuras($item)) {
                        $this->decreaseQuality($item);
                    }
                }
            } else {
                if ($this->qualityLessThan50($item)) {
                    $this->increaseQuality($item);
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->sell_in < 11) {
                            if ($this->qualityLessThan50($item)) {
                                $this->increaseQuality($item);
                            }
                        }
                        if ($item->sell_in < 6) {
                            if ($this->qualityLessThan50($item)) {
                                $this->increaseQuality($item);
                            }
                        }
                    }
                }
            }

            if (!$this->isSulfuras($item)) {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->sell_in < 0) {
                if (!$this->isAgedBrie($item)) {
                    if (!$this->isBackstagePass($item)) {
                        if ($item->quality > 0) {
                            if (!$this->isSulfuras($item)) {
                                $this->decreaseQuality($item);
                            }
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($this->qualityLessThan50($item)) {
                        $this->increaseQuality($item);
                    }
                }
            }
        }
    }

    /**
     * @param Item $item
     */
    private function decreaseQuality(Item $item): void
    {
        $item->quality = $item->quality - 1;
    }

    /**
     * @param Item $item
     */
    private function increaseQuality(Item $item): void
    {
        $item->quality = $item->quality + 1;
    }

    /**
     * @param Item $item
     * @return bool
     */
    private function qualityLessThan50(Item $item): bool
    {
        return $item->quality < 50;
    }

    /**
     * @param Item $item
     * @return bool
     */
    private function isAgedBrie(Item $item): bool
    {
        return $item->name == 'Aged Brie';
    }

    /**
     * @param Item $item
     * @return bool
     */
    private function isBackstagePass(Item $item): bool
    {
        return $item->name == 'Backstage passes to a TAFKAL80ETC concert';
    }

    /**
     * @param Item $item
     * @return bool
     */
    private function isSulfuras(Item $item): bool
    {
        return $item->name == 'Sulfuras, Hand of Ragnaros';
    }
}
