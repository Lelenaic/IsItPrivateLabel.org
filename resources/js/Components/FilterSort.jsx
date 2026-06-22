import { useState, useCallback, memo } from 'react'
import { Label, ListBox, Select, Slider } from '@heroui/react'

export default memo(function FilterSort({ onSortChange, onMinRatingChange }) {
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
                <Label>Sort by</Label>
                <Select.Trigger>
                    <Select.Value />
                    <Select.Indicator />
                </Select.Trigger>
                <Select.Popover>
                    <ListBox>
                        <ListBox.Item id="rating_desc" textValue="Rating (high to low)">
                            Rating (high to low)
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                        <ListBox.Item id="rating_asc" textValue="Rating (low to high)">
                            Rating (low to high)
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                        <ListBox.Item id="name_asc" textValue="Name (A-Z)">
                            Name (A-Z)
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                        <ListBox.Item id="name_desc" textValue="Name (Z-A)">
                            Name (Z-A)
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
                <Label>Min rating: {minRating}/10</Label>
                <Slider.Output />
                <Slider.Track>
                    <Slider.Fill />
                    <Slider.Thumb />
                </Slider.Track>
            </Slider>
        </div>
    )
})
