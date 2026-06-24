import { IconExternalLink, IconHelp, IconHome, IconMenu2, IconRocket } from '@tabler/icons-react'
import { Link } from '@inertiajs/react'
import { Drawer, Button } from '@heroui/react'
import { useTranslation } from '../hooks/useTranslation'
import LanguageSwitcher from './LanguageSwitcher'

export default function AppLayout({ children }) {
    const t = useTranslation()

    const navLinks = [
        {
            href: '/',
            icon: IconHome,
            label: t('layout.nav.home'),
        },
        {
            href: '/what-is-private-label',
            icon: IconHelp,
            label: t('layout.nav.what_is_private_label'),
        },
        {
            href: '/our-mission',
            icon: IconRocket,
            label: t('layout.nav.our_mission'),
        },
    ]

    return (
        <div className="min-h-screen flex flex-col bg-background text-foreground">
            <header className="border-b border-default/40">
                <div className="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                    <Link href="/" className="flex items-center gap-2">
                        <span className="text-xl font-bold tracking-tight">
                            IsIt<span className="text-danger">PrivateLabel</span>.org
                        </span>
                    </Link>

                    <nav className="hidden md:flex items-center gap-6">
                        {navLinks.map((link) => (
                            <Link
                                key={link.href}
                                href={link.href}
                                className="flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors"
                            >
                                <link.icon className="size-4" />
                                {link.label}
                            </Link>
                        ))}
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

                    <div className="flex md:hidden items-center gap-2">
                        <LanguageSwitcher compact />
                        <Drawer>
                            <Button isIconOnly variant="secondary" aria-label="Menu">
                                <IconMenu2 className="size-5" />
                            </Button>
                            <Drawer.Backdrop>
                                <Drawer.Content placement="right">
                                    <Drawer.Dialog>
                                        <Drawer.CloseTrigger />
                                        <Drawer.Header>
                                            <Drawer.Heading>Menu</Drawer.Heading>
                                        </Drawer.Header>
                                        <Drawer.Body>
                                            <nav className="flex flex-col gap-1">
                                                {navLinks.map((link) => (
                                                    <Link
                                                        key={link.href}
                                                        href={link.href}
                                                        className="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-foreground transition-colors hover:bg-default"
                                                    >
                                                        <link.icon className="size-5 text-muted" />
                                                        {link.label}
                                                    </Link>
                                                ))}
                                                <a
                                                    href="/api"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-foreground transition-colors hover:bg-default"
                                                >
                                                    <IconExternalLink className="size-5 text-muted" />
                                                    {t('layout.nav.api')}
                                                </a>
                                            </nav>
                                        </Drawer.Body>
                                    </Drawer.Dialog>
                                </Drawer.Content>
                            </Drawer.Backdrop>
                        </Drawer>
                    </div>
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
