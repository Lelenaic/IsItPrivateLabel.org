import { Link } from '@inertiajs/react'

export default function AppLayout({ children }) {
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
                            href="/what-is-private-label"
                            className="text-sm text-muted hover:text-foreground transition-colors"
                        >
                            What is private label?
                        </Link>
                        <Link
                            href="/our-mission"
                            className="text-sm text-muted hover:text-foreground transition-colors"
                        >
                            Our mission
                        </Link>
                        <Link
                            href="/"
                            className="text-sm text-muted hover:text-foreground transition-colors"
                        >
                            Home
                        </Link>
                    </nav>
                </div>
            </header>

            <main className="flex-1">
                {children}
            </main>

            <footer className="border-t border-default/40 py-6">
                <div className="max-w-6xl mx-auto px-4 text-center text-sm text-muted">
                    <p>
                        IsItPrivateLabel.org — Helping consumers identify private-labeled products.
                    </p>
                    <p className="mt-1 text-xs">
                        All ratings are based on publicly available evidence. Scores 1–9 indicate suspicion levels and are not definitive claims.
                    </p>
                </div>
            </footer>
        </div>
    )
}
