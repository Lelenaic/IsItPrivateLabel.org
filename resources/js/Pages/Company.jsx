import { Card, Chip, Link } from '@heroui/react'
import AppLayout from '../Components/AppLayout'
import RatingIndicator from '../Components/RatingIndicator'
import ProductCard from '../Components/ProductCard'

export default function Company({ company, averageRating }) {
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
                            ({company.products.length})
                        </span>
                    </h2>

                    {company.products.length > 0 ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            {company.products
                                .sort((a, b) => b.rating - a.rating)
                                .map((product) => (
                                    <ProductCard key={product.id} product={product} />
                                ))}
                        </div>
                    ) : (
                        <p className="text-muted text-center py-8">
                            No products listed for this company yet.
                        </p>
                    )}
                </div>
            </div>
        </AppLayout>
    )
}
