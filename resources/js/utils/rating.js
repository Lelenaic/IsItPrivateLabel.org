export function getRatingColor(rating) {
    if (rating <= 1) return 'success'
    if (rating <= 3) return 'success'
    if (rating <= 5) return 'warning'
    if (rating <= 7) return 'warning'
    if (rating <= 9) return 'danger'
    return 'danger'
}

export function getRatingTailwindColor(rating) {
    if (rating <= 1) return 'bg-green-500'
    if (rating <= 2) return 'bg-green-400'
    if (rating <= 3) return 'bg-emerald-400'
    if (rating <= 4) return 'bg-teal-400'
    if (rating <= 5) return 'bg-yellow-400'
    if (rating <= 6) return 'bg-amber-400'
    if (rating <= 7) return 'bg-orange-400'
    if (rating <= 8) return 'bg-orange-500'
    if (rating <= 9) return 'bg-red-400'
    return 'bg-red-500'
}

export function getRatingGradient(rating) {
    if (rating <= 1) return 'from-green-500 to-green-400'
    if (rating <= 2) return 'from-green-400 to-emerald-400'
    if (rating <= 3) return 'from-emerald-400 to-teal-400'
    if (rating <= 4) return 'from-teal-400 to-yellow-400'
    if (rating <= 5) return 'from-yellow-400 to-amber-400'
    if (rating <= 6) return 'from-amber-400 to-orange-400'
    if (rating <= 7) return 'from-orange-400 to-orange-500'
    if (rating <= 8) return 'from-orange-500 to-red-400'
    if (rating <= 9) return 'from-red-400 to-red-500'
    return 'from-red-500 to-red-600'
}

export function getRatingLabel(rating) {
    if (rating === 0) return 'Verified non private label'
    if (rating <= 2) return 'Very unlikely private label'
    if (rating <= 4) return 'Unlikely private label'
    if (rating <= 6) return 'Suspicious'
    if (rating <= 8) return 'Likely private label'
    if (rating === 9) return 'Very likely private label'
    return 'Confirmed private label'
}

export function getPlatformLabel(platform) {
    const labels = {
        aliexpress: 'AliExpress',
        'made-in-china': 'Made-in-China',
        alibaba: 'Alibaba',
        company: 'Company',
        other: 'Link',
    }
    return labels[platform] || 'Link'
}

export function getPlatformColor(platform) {
    const colors = {
        aliexpress: 'danger',
        'made-in-china': 'warning',
        alibaba: 'accent',
        company: 'default',
        other: 'default',
    }
    return colors[platform] || 'default'
}
