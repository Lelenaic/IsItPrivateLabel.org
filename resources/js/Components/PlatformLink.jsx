import { Chip, Link } from '@heroui/react'
import { getPlatformLabel, getPlatformColor } from '../utils/rating'

export default function PlatformLink({ link }) {
    const label = getPlatformLabel(link.platform)
    const color = getPlatformColor(link.platform)

    return (
        <div className="flex items-center gap-3">
            <Chip color={color} size="sm" variant="flat">
                {label}
            </Chip>
            <Link
                href={link.url}
                isExternal
                showAnchorIcon
                className="text-sm"
            >
                {link.label || link.url}
            </Link>
        </div>
    )
}
