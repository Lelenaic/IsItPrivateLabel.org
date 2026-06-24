import AppLayout from '../Components/AppLayout'
import { useTranslation } from '../hooks/useTranslation'

export default function OurMission() {
    const t = useTranslation()

    return (
        <AppLayout>
            <div className="max-w-3xl mx-auto px-4 py-16 space-y-8">
                <h1 className="text-3xl sm:text-4xl font-bold tracking-tight">
                    {t('our_mission.title_prefix')} <span className="text-danger">{t('our_mission.title_highlight')}</span>
                </h1>

                <div className="space-y-6 text-muted leading-relaxed">
                    <p>
                        {t('our_mission.statement')}
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">{t('our_mission.what_we_do_title')}</h2>
                    <p>
                        {t('our_mission.what_we_do')}
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">{t('our_mission.how_we_score_title')}</h2>
                    <p>
                        {t('our_mission.how_we_score')}
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">{t('our_mission.our_principles_title')}</h2>
                    <ul className="list-disc list-inside space-y-2">
                        <li>
                            {t('our_mission.transparency')}
                        </li>
                        <li>
                            {t('our_mission.fairness')}
                        </li>
                        <li>
                            {t('our_mission.accuracy')}
                        </li>
                    </ul>
                </div>
            </div>
        </AppLayout>
    )
}
