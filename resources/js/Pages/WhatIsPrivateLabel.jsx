import AppLayout from '../Components/AppLayout'
import { useTranslation } from '../hooks/useTranslation'

export default function WhatIsPrivateLabel() {
    const t = useTranslation()

    return (
        <AppLayout>
            <div className="max-w-3xl mx-auto px-4 py-16 space-y-8">
                <h1 className="text-4xl font-bold tracking-tight">
                    {t('what_is_private_label.title_prefix')} <span className="text-danger">{t('what_is_private_label.title_highlight')}</span>?
                </h1>

                <div className="space-y-6 text-muted leading-relaxed">
                    <p>
                        {t('what_is_private_label.definition')}
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">{t('what_is_private_label.how_it_works_title')}</h2>
                    <p>
                        {t('what_is_private_label.how_it_works')}
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">{t('what_is_private_label.why_it_matters_title')}</h2>
                    <p>
                        {t('what_is_private_label.why_it_matters')}
                    </p>

                    <p>
                        {t('what_is_private_label.conclusion')}
                    </p>
                </div>
            </div>
        </AppLayout>
    )
}
