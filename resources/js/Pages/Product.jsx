import { Link as InertiaLink } from '@inertiajs/react'
import { Card, Chip, Link, Separator } from '@heroui/react'
import AppLayout from '../Components/AppLayout'
import RatingIndicator from '../Components/RatingIndicator'
import PlatformLink from '../Components/PlatformLink'
import ProofItem from '../Components/ProofItem'
import { useTranslation } from '../hooks/useTranslation'

export default function Product({ product }) {
    const t = useTranslation()

    return (
        <AppLayout>
            <div className="max-w-4xl mx-auto px-4 py-8 space-y-8">
                <div className="space-y-6">
                    <button
                        onClick={() => window.history.back()}
                        className="inline-flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors cursor-pointer"
                    >
                        {t('product.back_to_results')}
                    </button>
                    <div className="flex flex-col sm:flex-row gap-6 items-start">
                        {product.image_path && (
                            <div className="w-full sm:w-48 shrink-0">
                                <img
                                    src={product.image_path}
                                    alt={product.name}
                                    className="w-full h-auto rounded-2xl object-cover"
                                />
                            </div>
                        )}
                        <div className="flex-1 space-y-3">
                            <h1 className="text-2xl sm:text-3xl font-bold tracking-tight">
                                {product.name}
                            </h1>
                            <div className="flex items-center gap-2 text-sm text-muted">
                                <span>{t('product.by')}</span>
                                <InertiaLink
                                    href={`/companies/${product.company?.slug}`}
                                    className="text-foreground font-medium hover:underline"
                                >
                                    {product.company?.name}
                                </InertiaLink>
                            </div>
                            {product.serial_number && (
                                <p className="text-sm text-muted font-mono">
                                    {t('product.serial_prefix')} {product.serial_number}
                                </p>
                            )}
                            {product.description && (
                                <p className="text-sm text-foreground/70 leading-relaxed">
                                    {product.description}
                                </p>
                            )}
                        </div>
                    </div>

                    <Card className="p-6">
                        <div className="space-y-3">
                            <h2 className="text-sm font-semibold text-muted uppercase tracking-wide">
                                {t('product.suspicion_score')}
                            </h2>
                            <RatingIndicator rating={product.rating} size="lg" />
                        </div>
                    </Card>
                </div>

                {product.links && product.links.length > 0 && (
                    <div className="space-y-4">
                        <h2 className="text-lg font-semibold">{t('product.external_links')}</h2>
                        <Card className="p-4">
                            <div className="space-y-3">
                                {product.links.map((link) => (
                                    <PlatformLink key={link.id} link={link} />
                                ))}
                                {product.company_url && (
                                    <div className="flex items-center gap-3">
                                        <Chip color="default" size="sm" variant="flat">
                                            {t('product.company_chip')}
                                        </Chip>
                                        <Link
                                            href={product.company_url}
                                            isExternal
                                            showAnchorIcon
                                            className="text-sm"
                                        >
                                            {t('product.view_on_company_website')}
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </Card>
                    </div>
                )}

                {product.proofs && product.proofs.length > 0 && (
                    <div className="space-y-4">
                        <h2 className="text-lg font-semibold">
                            {t('product.evidence_and_proofs')}
                            <span className="text-sm font-normal text-muted ml-2">
                                ({product.proofs.length})
                            </span>
                        </h2>
                        <div className="space-y-3">
                            {product.proofs.map((proof) => (
                                <ProofItem key={proof.id} proof={proof} />
                            ))}
                        </div>
                    </div>
                )}

                <div className="text-center pt-4">
                    <InertiaLink
                        href={`/companies/${product.company?.slug}`}
                        className="text-sm text-muted hover:text-foreground transition-colors"
                    >
                        {t('product.view_all_products', { name: product.company?.name })}
                    </InertiaLink>
                </div>
            </div>
        </AppLayout>
    )
}
