import { useState, useCallback, memo } from 'react'
import { Label, ListBox, Select, Slider } from '@heroui/react'
import { useTranslation } from '../hooks/useTranslation'

export default memo(function FilterSort({ onSortChange, onMinRatingChange }) {
    const t = useTranslation()
    const [sort, setSort] = useState('rating_desc')
    const [minRating, setMinRating] = useState(0)

    const handleSortChange = useCallback(
        (value) => {
            setSort(value)
            onSortChange(value)
        },
        [onSortChange],
    )

    const handleRatingChange = useCallback(
        (value) => {
            const val = Array.isArray(value) ? value[0] : value
            setMinRating(val)
            onMinRatingChange(val)
        },
        [onMinRatingChange],
    )

    return (
        <div className="flex flex-wrap items-end gap-4">
            <Select
                className="w-56"
                value={sort}
                onChange={handleSortChange}
            >
                <Label>{t('filter_sort.sort_by')}</Label>
                <Select.Trigger>
                    <Select.Value />
                    <Select.Indicator />
                </Select.Trigger>
                <Select.Popover>
                    <ListBox>
                        <ListBox.Item id="rating_desc" textValue={t('filter_sort.rating_high_to_low')}>
                            {t('filter_sort.rating_high_to_low')}
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                        <ListBox.Item id="rating_asc" textValue={t('filter_sort.rating_low_to_high')}>
                            {t('filter_sort.rating_low_to_high')}
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                        <ListBox.Item id="name_asc" textValue={t('filter_sort.name_a_to_z')}>
                            {t('filter_sort.name_a_to_z')}
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                        <ListBox.Item id="name_desc" textValue={t('filter_sort.name_z_to_a')}>
                            {t('filter_sort.name_z_to_a')}
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                    </ListBox>
                </Select.Popover>
            </Select>

            <Slider
                className="w-64"
                minValue={0}
                maxValue={10}
                step={1}
                value={minRating}
                onChange={handleRatingChange}
            >
                <Label>{t('filter_sort.min_rating', { value: minRating })}</Label>
                <Slider.Output />
                <Slider.Track>
                    <Slider.Fill />
                    <Slider.Thumb />
                </Slider.Track>
            </Slider>
        </div>
    )
})
