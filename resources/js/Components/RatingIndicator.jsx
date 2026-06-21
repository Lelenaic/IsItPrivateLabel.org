import { Chip } from '@heroui/react'
import { getRatingColor, getRatingLabel, getRatingTailwindColor } from '../utils/rating'

export default function RatingIndicator({ rating, size = 'md', showLabel = true }) {
    const color = getRatingColor(rating)
    const label = getRatingLabel(rating)
    const barColor = getRatingTailwindColor(rating)

    return (
        <div className="flex flex-col gap-2">
            <div className="flex items-center gap-3">
                <div className="relative w-full max-w-xs">
                    <div className="h-2.5 rounded-full bg-default/40 overflow-hidden">
                        <div
                            className={`h-full rounded-full transition-all duration-500 ${barColor}`}
                            style={{ width: `${rating * 10}%` }}
                        />
                    </div>
                </div>
                <span className="text-lg font-bold tabular-nums min-w-[2ch] text-right">
                    {rating}
                </span>
                <span className="text-sm text-muted">/10</span>
            </div>
            {showLabel && (
                <Chip color={color} size={size} variant="soft">
                    {label}
                </Chip>
            )}
        </div>
    )
}
