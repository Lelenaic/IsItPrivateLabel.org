import AppLayout from '../Components/AppLayout'

export default function OurMission() {
    return (
        <AppLayout>
            <div className="max-w-3xl mx-auto px-4 py-16 space-y-8">
                <h1 className="text-4xl font-bold tracking-tight">
                    Our <span className="text-danger">Mission</span>
                </h1>

                <div className="space-y-6 text-muted leading-relaxed">
                    <p>
                        IsItPrivateLabel.org exists to bring transparency to the marketplace. We believe
                        consumers deserve to know when a product they are considering is not what it
                        appears to be.
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">What We Do</h2>
                    <p>
                        We research and catalog products that are suspected of being private-labeled —
                        items manufactured by one company and sold under another's brand. By collecting
                        publicly available evidence, we assign a suspicion score to help you gauge
                        how likely a product is to be a relabeled generic.
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">How We Score</h2>
                    <p>
                        Our ratings range from 1 to 9, where higher scores indicate stronger evidence
                        that a product is private-labeled. These scores are based on publicly available
                        information such as manufacturer listings, packaging similarities, and supply
                        chain data.
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">Our Principles</h2>
                    <ul className="list-disc list-inside space-y-2">
                        <li>
                            <strong className="text-foreground">Transparency:</strong> All our evidence
                            is publicly sourced and traceable. The code is open source, and the data are open.
                        </li>
                        <li>
                            <strong className="text-foreground">Fairness:</strong> We are not against
                            private-label products. This website aims to warn customers before buying potentially misleading products. Every company can make a claim on the product page if the product is badly noted.
                        </li>
                        <li>
                            <strong className="text-foreground">Accuracy:</strong> Our scores reflect
                            evidence levels, not definitive claims.
                        </li>
                    </ul>
                </div>
            </div>
        </AppLayout>
    )
}
