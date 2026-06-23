import { usePage } from '@inertiajs/react'

export function useTranslation() {
    const { translations } = usePage().props

    return (key, replacements = {}) => {
        let value = translations[key] ?? key
        for (const [placeholder, val] of Object.entries(replacements)) {
            value = value.replaceAll(`:${placeholder}`, val)
        }
        return value
    }
}
