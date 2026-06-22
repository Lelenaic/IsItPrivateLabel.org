import { useState, useMemo } from 'react'
import { Card, Link } from '@heroui/react'
import AppLayout from '../Components/AppLayout'
import RatingIndicator from '../Components/RatingIndicator'
import ProductCard from '../Components/ProductCard'
import FilterSort from '../Components/FilterSort'

export default function Company({ company, averageRating }) {
    const [sort, setSort] = useState('rating_desc')
    const [minRating, setMinRating] = useState(0)

    const filteredProducts = useMemo(() => {
        let products = [...company.products]

        if (minRating > 0) {
            products = products.filter((p) => p.rating >= minRating)
        }

        const sortFns = {
            rating_desc: (a, b) => b.rating - a.rating,
            rating_asc: (a, b) => a.rating - b.rating,
            name_asc: (a, b) => a.name.localeCompare(b.name),
            name_desc: (a, b) => b.name.localeCompare(a.name),
        }

        if (sortFns[sort]) {
            products.sort(sortFns[sort])
        }

        return products
    }, [company.products, sort, minRating])

    return (
        <AppLayout>
            <div className="max-w-6xl mx-auto px-4 py-8 space-y-8">
                <div className="space-y-4">
                    <button
                        onClick={() => window.history.back()}
                        className="inline-flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors cursor-pointer"
                    >
                        ← Back
                    </button>
                    <h1 className="text-2xl sm:text-3xl font-bold tracking-tight">
                        {company.name}
                    </h1>

                    {company.description && (
                        <p className="text-foreground/70 max-w-2xl">
                            {company.description}
                        </p>
                    )}

                    {company.website_url && (
                        <Link
                            href={company.website_url}
                            isExternal
                            showAnchorIcon
                            className="text-sm"
                        >
                            {company.website_url}
                        </Link>
                    )}

                    <Card className="p-6">
                        <div className="space-y-3">
                            <h2 className="text-sm font-semibold text-muted uppercase tracking-wide">
                                Average Suspicion Score
                            </h2>
                            <div className="flex items-center gap-4">
                                <span className="text-4xl font-bold">{averageRating}</span>
                                <span className="text-muted">/ 10</span>
                            </div>
                            <RatingIndicator rating={Math.round(averageRating)} size="md" />
                            <p className="text-xs text-muted">
                                Based on {company.products.length} product{company.products.length !== 1 ? 's' : ''}
                            </p>
                        </div>
                    </Card>
                </div>

                <div className="space-y-4">
                    <h2 className="text-lg font-semibold">
                        Products
                        <span className="text-sm font-normal text-muted ml-2">
                            ({filteredProducts.length})
                        </span>
                    </h2>

                    <FilterSort onSortChange={setSort} onMinRatingChange={setMinRating} />

                    {filteredProducts.length > 0 ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            {filteredProducts.map((product) => (
                                <ProductCard key={product.id} product={product} />
                            ))}
                        </div>
                    ) : (
                        <p className="text-muted text-center py-8">
                            No products match the current filters.
                        </p>
                    )}
                </div>
            </div>
        </AppLayout>
    )
}
