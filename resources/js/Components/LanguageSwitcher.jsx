import { IconLanguage } from '@tabler/icons-react'
import { router, usePage } from '@inertiajs/react'
import { Label, ListBox, Select } from '@heroui/react'

export default function LanguageSwitcher({ compact = false }) {
    const { locale, languages } = usePage().props
    const { url } = usePage()

    const handleLanguageChange = (code) => {
        if (code !== locale) {
            localStorage.setItem('locale', code)
            router.get(`/language/${code}`, { redirect: url })
        }
    }

    if (languages.length <= 1) {
        return null
    }

    return (
        <Select
            className={compact ? 'w-auto' : 'w-36'}
            value={locale}
            onChange={handleLanguageChange}
        >
            <Label className="sr-only">Language</Label>
            <Select.Trigger className={compact ? 'items-center gap-1.5' : 'items-center gap-2.5'}>
                <span className="flex size-7 shrink-0 items-center justify-center rounded-full bg-default text-foreground">
                    <IconLanguage className="size-4" />
                </span>
                {compact && <span className="text-sm font-medium">{locale.toUpperCase()}</span>}
                {!compact && <Select.Value />}
                {!compact && <Select.Indicator />}
            </Select.Trigger>
            <Select.Popover>
                <ListBox>
                    {languages.map((lang) => (
                        <ListBox.Item key={lang.code} id={lang.code} textValue={lang.name} className={lang.code === locale ? 'bg-default' : ''}>
                            {lang.name}
                        </ListBox.Item>
                    ))}
                </ListBox>
            </Select.Popover>
        </Select>
    )
}
