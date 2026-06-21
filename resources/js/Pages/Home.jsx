import { useState, useEffect, useRef, useCallback } from 'react'
import { SearchField, Label } from '@heroui/react'
import AppLayout from '../Components/AppLayout'
import ProductCard from '../Components/ProductCard'

export default function Home() {
    const [query, setQuery] = useState('')
    const [results, setResults] = useState([])
    const [loading, setLoading] = useState(false)
    const [searched, setSearched] = useState(false)
    const abortRef = useRef(null)
    const debounceRef = useRef(null)
    const restoredRef = useRef(false)

    const doSearch = useCallback((q) => {
        if (q.trim().length < 2) {
            setResults([])
            setSearched(false)
            return
        }

        if (abortRef.current) {
            abortRef.current.abort()
        }

        const controller = new AbortController()
        abortRef.current = controller
        setLoading(true)
        setSearched(true)

        fetch(`/search?q=${encodeURIComponent(q.trim())}`, {
            signal: controller.signal,
        })
            .then((res) => res.json())
            .then((data) => {
                setResults(data)
                setLoading(false)
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
            return
        }

        debounceRef.current = setTimeout(() => {
            doSearch(query)
        }, 300)

        return () => {
            if (debounceRef.current) {
                clearTimeout(debounceRef.current)
            }
        }
    }, [query, doSearch])

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
                            <div className="inline-block h-6 w-6 animate-spin rounded-full border-2 border-foreground border-t-transparent" />
                        </div>
                    ) : results.length > 0 ? (
                        <div className="space-y-4">
                            <p className="text-sm text-muted text-center">
                                Found <strong className="text-foreground">{results.length}</strong> result{results.length !== 1 ? 's' : ''}
                            </p>
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {results.map((product) => (
                                    <ProductCard key={product.id} product={product} searchQuery={query} />
                                ))}
                            </div>
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
