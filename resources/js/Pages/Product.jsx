import { useState, useCallback } from 'react'
import { Link as InertiaLink } from '@inertiajs/react'
import { Alert, Card, Checkbox, Chip, Link, Spinner } from '@heroui/react'
import AppLayout from '../Components/AppLayout'
import RatingIndicator from '../Components/RatingIndicator'
import PlatformLink from '../Components/PlatformLink'
import ProofItem from '../Components/ProofItem'
import { useTranslation } from '../hooks/useTranslation'

export default function Product({ product, translation, availableInLocale, proofs }) {
    const t = useTranslation()
    const [showAllProofs, setShowAllProofs] = useState(false)
    const [allProofs, setAllProofs] = useState(null)
    const [loadingAllProofs, setLoadingAllProofs] = useState(false)

    const displayName = translation?.name ?? product.name
    const displayDescription = translation?.description
    const displayImage = translation?.image_path
    const displayCompanyUrl = translation?.company_url

    const fetchAllProofs = useCallback(async () => {
        if (allProofs) {
            return
        }

        setLoadingAllProofs(true)
        try {
            const res = await fetch(`/products/${product.slug}/all-proofs`)
            const data = await res.json()
            setAllProofs(data.proofs)
        } catch {
            // keep showing current proofs on error
        } finally {
            setLoadingAllProofs(false)
        }
    }, [allProofs, product.slug])

    const handleShowAllProofs = async (checked) => {
        if (checked) {
            await fetchAllProofs()
        }
        setShowAllProofs(checked)
    }

    const displayProofs = showAllProofs && allProofs ? allProofs : proofs

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

                    {!availableInLocale && (
                        <Alert color="warning" variant="flat">
                            {t('product.translation_unavailable_notice', { language: 'English' })}
                        </Alert>
                    )}

                    <div className="flex flex-col sm:flex-row gap-6 items-start">
                        {displayImage && (
                            <div className="w-full sm:w-48 shrink-0">
                                <img
                                    src={displayImage}
                                    alt={displayName}
                                    className="w-full h-auto rounded-2xl object-cover"
                                />
                            </div>
                        )}
                        <div className="flex-1 space-y-3">
                            <h1 className="text-2xl sm:text-3xl font-bold tracking-tight">
                                {displayName}
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
                            {displayDescription && (
                                <p className="text-sm text-foreground/70 leading-relaxed">
                                    {displayDescription}
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

                    {product.pricings && product.pricings.length > 0 && (
                        <Card className="p-6">
                            <div className="space-y-4">
                                <h2 className="text-sm font-semibold text-muted uppercase tracking-wide">
                                    {t('pricing.resale_price')}
                                </h2>
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    {product.pricings.map((pricing) => (
                                        <div key={pricing.id} className="flex items-center gap-3">
                                            <div className="flex-1">
                                                <p className="text-lg font-bold">
                                                    {Number(pricing.amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                                    <Chip size="sm" variant="flat" color="default" className="ml-2">
                                                        {pricing.currency}
                                                    </Chip>
                                                </p>
                                                <p className="text-xs text-muted capitalize">
                                                    {pricing.type === 'resale' ? t('pricing.resale_price') : t('pricing.source_price')}
                                                </p>
                                                {pricing.comment && (
                                                    <p className="text-xs text-muted mt-1">
                                                        {pricing.comment}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </Card>
                    )}
                </div>

                {product.links && product.links.length > 0 && (
                    <div className="space-y-4">
                        <h2 className="text-lg font-semibold">{t('product.external_links')}</h2>
                        <Card className="p-4">
                            <div className="space-y-3">
                                {product.links.map((link) => (
                                    <PlatformLink key={link.id} link={link} />
                                ))}
                                {displayCompanyUrl && (
                                    <div className="flex items-center gap-3">
                                        <Chip color="default" size="sm" variant="flat">
                                            {t('product.company_chip')}
                                        </Chip>
                                        <Link
                                            href={displayCompanyUrl}
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

                {proofs && proofs.length > 0 && (
                    <div className="space-y-4">
                        <div className="flex items-center justify-between">
                            <h2 className="text-lg font-semibold">
                                {t('product.evidence_and_proofs')}
                                <span className="text-sm font-normal text-muted ml-2">
                                    ({showAllProofs && allProofs ? allProofs.length : proofs.length})
                                </span>
                            </h2>
                            <Checkbox
                                isSelected={showAllProofs}
                                onChange={handleShowAllProofs}
                            >
                                <Checkbox.Content>
                                    <Checkbox.Control>
                                        <Checkbox.Indicator />
                                    </Checkbox.Control>
                                    {t('product.show_all_proofs')}
                                </Checkbox.Content>
                            </Checkbox>
                        </div>
                        {loadingAllProofs ? (
                            <div className="flex justify-center py-6">
                                <Spinner size="md" />
                            </div>
                        ) : (
                            <div className="space-y-3">
                                {displayProofs.map((proof) => (
                                    <ProofItem key={proof.id} proof={proof} />
                                ))}
                            </div>
                        )}
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
