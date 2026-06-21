import AppLayout from '../Components/AppLayout'

export default function WhatIsPrivateLabel() {
    return (
        <AppLayout>
            <div className="max-w-3xl mx-auto px-4 py-16 space-y-8">
                <h1 className="text-4xl font-bold tracking-tight">
                    What is <span className="text-danger">Private Label</span>?
                </h1>

                <div className="space-y-6 text-muted leading-relaxed">
                    <p>
                        Private label products are manufactured by one company and sold under another
                        company's brand name. Also known as store brands or generic brands, these
                        products are designed to look like they come from a unique or independent
                        manufacturer, but are actually produced by a third-party supplier.
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">How It Works</h2>
                    <p>
                        A retailer or distributor contracts with a manufacturer to produce goods
                        according to their specifications. The manufacturer then packages and labels
                        the product under the buyer's brand. This allows companies to offer products
                        that appear exclusive to their store or brand, often at lower prices than
                        name-brand alternatives.
                    </p>

                    <h2 className="text-2xl font-semibold text-foreground">Why It Matters</h2>
                    <p>
                        Private labeling is widespread across industries — from electronics and
                        supplements to cosmetics and food products. While not inherently bad, the
                        practice can be misleading when consumers believe they are buying from an
                        independent brand when the same product is sold by many companies under
                        different names.
                    </p>

                    <p>
                        Understanding which products are private-labeled helps consumers make more
                        informed purchasing decisions and identify when they are paying a premium for
                        branding rather than quality or uniqueness.
                    </p>
                </div>
            </div>
        </AppLayout>
    )
}
