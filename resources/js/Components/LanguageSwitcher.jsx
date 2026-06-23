import { router, usePage } from '@inertiajs/react'
import { Label, ListBox, Select } from '@heroui/react'

export default function LanguageSwitcher() {
    const { locale, languages } = usePage().props

    const handleLanguageChange = (code) => {
        if (code !== locale) {
            router.get(route('language.switch', { language: code }))
        }
    }

    if (languages.length <= 1) {
        return null
    }

    return (
        <Select
            className="w-36"
            value={locale}
            onChange={handleLanguageChange}
        >
            <Label className="sr-only">Language</Label>
            <Select.Trigger>
                <Select.Value />
                <Select.Indicator />
            </Select.Trigger>
            <Select.Popover>
                <ListBox>
                    {languages.map((lang) => (
                        <ListBox.Item key={lang.code} id={lang.code} textValue={lang.name}>
                            {lang.name}
                            <ListBox.ItemIndicator />
                        </ListBox.Item>
                    ))}
                </ListBox>
            </Select.Popover>
        </Select>
    )
}
