import { Card, Chip } from '@heroui/react'
import { Link } from '@inertiajs/react'
import { getRatingColor, getRatingLabel, getRatingTailwindColor } from '../utils/rating'

export default function ProductCard({ product, searchQuery = '' }) {
    const ratingColor = getRatingColor(product.rating)
    const ratingLabel = getRatingLabel(product.rating)
    const barColor = getRatingTailwindColor(product.rating)

    const handleClick = () => {
        localStorage.setItem('searchQuery', searchQuery)
        localStorage.setItem('searchScrollY', String(window.scrollY))
    }

    return (
        <Link href={`/products/${product.slug}`} onClick={handleClick}>
            <Card className="h-full hover:shadow-lg transition-shadow duration-200 cursor-pointer">
                {product.image_path ? (
                    <div className="aspect-video overflow-hidden rounded-t-2xl">
                        <img
                            src={product.image_path}
                            alt={product.name}
                            className="w-full h-full object-cover"
                        />
                    </div>
                ) : (
                    <div className="aspect-video bg-default-200 flex items-center justify-center rounded-t-2xl">
                        <span className="text-default-500 text-lg font-medium px-4 text-center line-clamp-2">
                            {product.name}
                        </span>
                    </div>
                )}
                <Card.Header>
                    <div className="flex items-start justify-between gap-2 w-full">
                        <div className="flex-1 min-w-0">
                            <Card.Title className="text-base truncate">
                                {product.name}
                            </Card.Title>
                            <Card.Description className="text-sm">
                                {product.company?.name}
                            </Card.Description>
                        </div>
                        <Chip color={ratingColor} size="sm" variant="soft">
                            {product.rating}/10
                        </Chip>
                    </div>
                </Card.Header>
                <Card.Content>
                    <div className="flex flex-col gap-2">
                        <div className="flex items-center gap-2">
                            <div className="flex-1 h-2 rounded-full bg-default/40 overflow-hidden">
                                <div
                                    className={`h-full rounded-full ${barColor}`}
                                    style={{ width: `${product.rating * 10}%` }}
                                />
                            </div>
                        </div>
                        <span className="text-xs text-muted">{ratingLabel}</span>
                        {product.serial_number && (
                            <span className="text-xs text-muted font-mono">
                                SN: {product.serial_number}
                            </span>
                        )}
                    </div>
                </Card.Content>
            </Card>
        </Link>
    )
}
