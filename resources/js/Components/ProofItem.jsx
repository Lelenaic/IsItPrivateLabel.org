import { Card, Chip, Link } from '@heroui/react'
import { useTranslation } from '../hooks/useTranslation'

export default function ProofItem({ proof }) {
    const t = useTranslation()

    const typeIcons = {
        text: '📝',
        image: '🖼️',
        link: '🔗',
        file: '📄',
    }

    return (
        <Card variant="transparent" className="border border-default/40">
            <Card.Header>
                <div className="flex items-center gap-2">
                    <span className="text-sm">{typeIcons[proof.type] || '📎'}</span>
                    <Chip size="sm" variant="flat" color="default">
                        {proof.type.charAt(0).toUpperCase() + proof.type.slice(1)}
                    </Chip>
                    {proof.description && (
                        <span className="text-sm text-muted">{proof.description}</span>
                    )}
                </div>
            </Card.Header>
            <Card.Content>
                {proof.type === 'text' && (
                    <p className="text-sm text-foreground/80 leading-relaxed">
                        {proof.content}
                    </p>
                )}
                {proof.type === 'image' && (
                    <img
                        src={proof.content}
                        alt={proof.description || t('proof_item.proof_image_alt')}
                        className="max-w-full h-auto rounded-lg max-h-64 object-contain"
                    />
                )}
                {proof.type === 'link' && (
                    <Link
                        href={proof.content}
                        isExternal
                        showAnchorIcon
                        className="text-sm"
                    >
                        {proof.description || proof.content}
                    </Link>
                )}
                {proof.type === 'file' && (
                    <Link
                        href={proof.content}
                        isExternal
                        showAnchorIcon
                        className="text-sm"
                    >
                        {t('proof_item.download_file')}
                    </Link>
                )}
            </Card.Content>
        </Card>
    )
}
