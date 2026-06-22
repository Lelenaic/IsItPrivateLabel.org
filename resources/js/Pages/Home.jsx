import { useState, useEffect, useRef, useCallback } from 'react'
import { SearchField, Label, Spinner } from '@heroui/react'
import AppLayout from '../Components/AppLayout'
import ProductCard from '../Components/ProductCard'
import FilterSort from '../Components/FilterSort'

export default function Home() {
    const [query, setQuery] = useState('')
    const [results, setResults] = useState([])
    const [loading, setLoading] = useState(false)
    const [loadingMore, setLoadingMore] = useState(false)
    const [searched, setSearched] = useState(false)
    const [meta, setMeta] = useState(null)
    const [sort, setSort] = useState('rating_desc')
    const [minRating, setMinRating] = useState(0)
    const abortRef = useRef(null)
    const abortMoreRef = useRef(null)
    const debounceRef = useRef(null)
    const restoredRef = useRef(false)
    const currentPageRef = useRef(1)
    const sentinelRef = useRef(null)

    const doSearch = useCallback((q, page = 1, currentSort, currentMinRating) => {
        if (q.trim().length < 2) {
            setResults([])
            setSearched(false)
            setMeta(null)
            return
        }

        if (page === 1 && abortRef.current) {
            abortRef.current.abort()
        }
        if (page > 1 && abortMoreRef.current) {
            abortMoreRef.current.abort()
        }

        const controller = new AbortController()
        if (page === 1) {
            abortRef.current = controller
        } else {
            abortMoreRef.current = controller
        }

        if (page === 1) {
            setLoading(true)
        } else {
            setLoadingMore(true)
        }
        setSearched(true)
        currentPageRef.current = page

        const params = new URLSearchParams({
            q: q.trim(),
            page: String(page),
            sort: currentSort || 'rating_desc',
        })
        if (currentMinRating && currentMinRating > 0) {
            params.set('min_rating', String(currentMinRating))
        }

        fetch(`/search?${params.toString()}`, {
            signal: controller.signal,
        })
            .then((res) => res.json())
            .then((data) => {
                if (page === 1) {
                    setResults(data.data)
                } else {
                    setResults((prev) => [...prev, ...data.data])
                }
                setMeta(data.meta)
                setLoading(false)
                setLoadingMore(false)

                if (restoredRef.current) {
                    restoredRef.current = false
                    const scrollY = localStorage.getItem('searchScrollY')
                    if (scrollY) {
                        requestAnimationFrame(() => {
                            window.scrollTo(0, parseInt(scrollY, 10))
                        })
                    }
                    localStorage.removeItem('searchScrollY')
                }
            })
            .catch((err) => {
                if (err.name !== 'AbortError') {
                    setLoading(false)
                    setLoadingMore(false)
                }
            })
    }, [])

    useEffect(() => {
        const savedQuery = localStorage.getItem('searchQuery')
        if (savedQuery) {
            localStorage.removeItem('searchQuery')
            restoredRef.current = true
            setQuery(savedQuery)
        }
    }, [])

    useEffect(() => {
        if (debounceRef.current) {
            clearTimeout(debounceRef.current)
        }

        if (query.trim().length < 2) {
            setResults([])
            setSearched(false)
            setMeta(null)
            currentPageRef.current = 1
            return
        }

        currentPageRef.current = 1

        debounceRef.current = setTimeout(() => {
            doSearch(query, 1, sort, minRating)
        }, 300)

        return () => {
            if (debounceRef.current) {
                clearTimeout(debounceRef.current)
            }
        }
    }, [query, sort, minRating, doSearch])

    const hasMore = meta && meta.current_page < meta.last_page

    useEffect(() => {
        if (!sentinelRef.current || !hasMore || loadingMore) {
            return
        }

        const observer = new IntersectionObserver(
            (entries) => {
                if (entries[0].isIntersecting && hasMore && !loadingMore && !loading) {
                    const nextPage = currentPageRef.current + 1
                    doSearch(query, nextPage, sort, minRating)
                }
            },
            { rootMargin: '200px' },
        )

        observer.observe(sentinelRef.current)

        return () => observer.disconnect()
    }, [hasMore, loadingMore, loading, query, sort, minRating, doSearch])

    return (
        <AppLayout>
            <div className="flex flex-col items-center px-4 pt-16 pb-8">
                <div className="max-w-2xl w-full text-center space-y-8">
                    <div className="space-y-4">
                        <h1 className="text-4xl sm:text-5xl font-bold tracking-tight">
                            Is It <span className="text-danger">Private Label</span>?
                        </h1>
                        <p className="text-lg text-muted max-w-lg mx-auto">
                            Search for a company, product, or serial number to check if it might be a private-labeled product.
                        </p>
                    </div>

                    <div className="w-full max-w-xl mx-auto">
                        <SearchField
                            name="search"
                            value={query}
                            onChange={setQuery}
                        >
                            <Label>Search</Label>
                            <SearchField.Group>
                                <SearchField.SearchIcon />
                                <SearchField.Input
                                    className="w-full"
                                    placeholder="Company name, product, or serial number..."
                                />
                                <SearchField.ClearButton />
                            </SearchField.Group>
                        </SearchField>
                    </div>

                    {!searched && (
                        <div className="flex flex-wrap justify-center gap-3 text-sm text-muted">
                            <span>Try:</span>
                            <button
                                onClick={() => setQuery('TechNova')}
                                className="text-foreground/70 hover:text-foreground underline underline-offset-2 transition-colors"
                            >
                                TechNova
                            </button>
                            <button
                                onClick={() => setQuery('sunset lamp')}
                                className="text-foreground/70 hover:text-foreground underline underline-offset-2 transition-colors"
                            >
                                sunset lamp
                            </button>
                            <button
                                onClick={() => setQuery('AliExpress')}
                                className="text-foreground/70 hover:text-foreground underline underline-offset-2 transition-colors"
                            >
                                AliExpress
                            </button>
                        </div>
                    )}
                </div>
            </div>

            {searched && (
                <div className="max-w-6xl mx-auto px-4 pb-16">
                    {loading ? (
                        <div className="text-center py-12">
                            <Spinner size="lg" />
                        </div>
                    ) : results.length > 0 ? (
                        <div className="space-y-4">
                            <p className="text-sm text-muted text-center">
                                Found <strong className="text-foreground">{meta?.total ?? results.length}</strong> result{(meta?.total ?? results.length) !== 1 ? 's' : ''}
                            </p>
                            <div className="flex justify-center">
                                <FilterSort onSortChange={setSort} onMinRatingChange={setMinRating} />
                            </div>
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {results.map((product) => (
                                    <ProductCard key={product.id} product={product} searchQuery={query} />
                                ))}
                            </div>
                            <div ref={sentinelRef} className="h-1" />
                            {loadingMore && (
                                <div className="text-center py-6">
                                    <Spinner size="md" />
                                </div>
                            )}
                        </div>
                    ) : (
                        <div className="text-center py-12 space-y-2">
                            <p className="text-3xl">🔍</p>
                            <p className="text-muted">
                                No results found for "<strong className="text-foreground">{query}</strong>"
                            </p>
                        </div>
                    )}
                </div>
            )}
        </AppLayout>
    )
}
