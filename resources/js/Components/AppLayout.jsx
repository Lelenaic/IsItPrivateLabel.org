import { IconExternalLink, IconHelp, IconHome, IconRocket } from '@tabler/icons-react'
import { Link } from '@inertiajs/react'
import { useTranslation } from '../hooks/useTranslation'
import LanguageSwitcher from './LanguageSwitcher'

export default function AppLayout({ children }) {
    const t = useTranslation()

    return (
        <div className="min-h-screen flex flex-col bg-background text-foreground">
            <header className="border-b border-default/40">
                <div className="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                    <Link href="/" className="flex items-center gap-2">
                        <span className="text-xl font-bold tracking-tight">
                            IsIt<span className="text-danger">PrivateLabel</span>.org
                        </span>
                    </Link>
                    <nav className="flex items-center gap-6">
                        <Link
                            href="/"
                            className="flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors"
                        >
                            <IconHome className="size-4" />
                            {t('layout.nav.home')}
                        </Link>
                        <Link
                            href="/what-is-private-label"
                            className="flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors"
                        >
                            <IconHelp className="size-4" />
                            {t('layout.nav.what_is_private_label')}
                        </Link>
                        <Link
                            href="/our-mission"
                            className="flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors"
                        >
                            <IconRocket className="size-4" />
                            {t('layout.nav.our_mission')}
                        </Link>
                        <a
                            href="/api"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors"
                        >
                            <IconExternalLink className="size-4" />
                            {t('layout.nav.api')}
                        </a>
                        <LanguageSwitcher />
                    </nav>
                </div>
            </header>

            <main className="flex-1">
                {children}
            </main>

            <footer className="border-t border-default/40 py-6">
                <div className="max-w-6xl mx-auto px-4 text-center text-sm text-muted">
                    <p>
                        {t('layout.footer.tagline')}
                    </p>
                    <p className="mt-1 text-xs">
                        {t('layout.footer.disclaimer')}
                    </p>
                </div>
            </footer>
        </div>
    )
}
