import { IconLanguage } from '@tabler/icons-react'
import { router, usePage } from '@inertiajs/react'
import { Label, ListBox, Select } from '@heroui/react'

export default function LanguageSwitcher() {
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
            className="w-36"
            value={locale}
            onChange={handleLanguageChange}
        >
            <Label className="sr-only">Language</Label>
            <Select.Trigger className="items-center gap-2.5">
                <span className="flex size-7 shrink-0 items-center justify-center rounded-full bg-default text-foreground">
                    <IconLanguage className="size-4" />
                </span>
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
