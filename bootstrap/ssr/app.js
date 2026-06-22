import { memo, useCallback, useEffect, useMemo, useRef, useState } from "react";
import { Card, Chip, Label, Link, ListBox, SearchField, Select, Slider, Spinner } from "@heroui/react";
import { Link as Link$1, createInertiaApp } from "@inertiajs/react";
import { jsx, jsxs } from "react/jsx-runtime";
import { createRoot } from "react-dom/client";
import createServer from "@inertiajs/react/server";
import { renderToString } from "react-dom/server";
//#region \0rolldown/runtime.js
var __defProp = Object.defineProperty;
var __exportAll = (all, no_symbols) => {
	let target = {};
	for (var name in all) __defProp(target, name, {
		get: all[name],
		enumerable: true
	});
	if (!no_symbols) __defProp(target, Symbol.toStringTag, { value: "Module" });
	return target;
};
//#endregion
//#region resources/js/Components/AppLayout.jsx
function AppLayout({ children }) {
	return /* @__PURE__ */ jsxs("div", {
		className: "min-h-screen flex flex-col bg-background text-foreground",
		children: [
			/* @__PURE__ */ jsx("header", {
				className: "border-b border-default/40",
				children: /* @__PURE__ */ jsxs("div", {
					className: "max-w-6xl mx-auto px-4 py-4 flex items-center justify-between",
					children: [/* @__PURE__ */ jsx(Link$1, {
						href: "/",
						className: "flex items-center gap-2",
						children: /* @__PURE__ */ jsxs("span", {
							className: "text-xl font-bold tracking-tight",
							children: [
								"IsIt",
								/* @__PURE__ */ jsx("span", {
									className: "text-danger",
									children: "PrivateLabel"
								}),
								".org"
							]
						})
					}), /* @__PURE__ */ jsxs("nav", {
						className: "flex items-center gap-6",
						children: [
							/* @__PURE__ */ jsx(Link$1, {
								href: "/",
								className: "text-sm text-muted hover:text-foreground transition-colors",
								children: "Home"
							}),
							/* @__PURE__ */ jsx(Link$1, {
								href: "/what-is-private-label",
								className: "text-sm text-muted hover:text-foreground transition-colors",
								children: "What is private label?"
							}),
							/* @__PURE__ */ jsx(Link$1, {
								href: "/our-mission",
								className: "text-sm text-muted hover:text-foreground transition-colors",
								children: "Our mission"
							})
						]
					})]
				})
			}),
			/* @__PURE__ */ jsx("main", {
				className: "flex-1",
				children
			}),
			/* @__PURE__ */ jsx("footer", {
				className: "border-t border-default/40 py-6",
				children: /* @__PURE__ */ jsxs("div", {
					className: "max-w-6xl mx-auto px-4 text-center text-sm text-muted",
					children: [/* @__PURE__ */ jsx("p", { children: "IsItPrivateLabel.org — Helping consumers identify private-labeled products." }), /* @__PURE__ */ jsx("p", {
						className: "mt-1 text-xs",
						children: "All ratings are based on publicly available evidence. Scores 1–9 indicate suspicion levels and are not definitive claims."
					})]
				})
			})
		]
	});
}
//#endregion
//#region resources/js/utils/rating.js
function getRatingColor(rating) {
	if (rating <= 1) return "success";
	if (rating <= 3) return "success";
	if (rating <= 5) return "warning";
	if (rating <= 7) return "warning";
	if (rating <= 9) return "danger";
	return "danger";
}
function getRatingTailwindColor(rating) {
	if (rating <= 1) return "bg-green-500";
	if (rating <= 2) return "bg-green-400";
	if (rating <= 3) return "bg-emerald-400";
	if (rating <= 4) return "bg-teal-400";
	if (rating <= 5) return "bg-yellow-400";
	if (rating <= 6) return "bg-amber-400";
	if (rating <= 7) return "bg-orange-400";
	if (rating <= 8) return "bg-orange-500";
	if (rating <= 9) return "bg-red-400";
	return "bg-red-500";
}
function getRatingLabel(rating) {
	if (rating === 0) return "Verified non private label";
	if (rating <= 2) return "Very unlikely private label";
	if (rating <= 4) return "Unlikely private label";
	if (rating <= 6) return "Suspicious";
	if (rating <= 8) return "Likely private label";
	if (rating === 9) return "Very likely private label";
	return "Confirmed private label";
}
function getPlatformLabel(platform) {
	return {
		aliexpress: "AliExpress",
		"made-in-china": "Made-in-China",
		alibaba: "Alibaba",
		company: "Company",
		other: "Link"
	}[platform] || "Link";
}
function getPlatformColor(platform) {
	return {
		aliexpress: "danger",
		"made-in-china": "warning",
		alibaba: "accent",
		company: "default",
		other: "default"
	}[platform] || "default";
}
//#endregion
//#region resources/js/Components/RatingIndicator.jsx
function RatingIndicator({ rating, size = "md", showLabel = true }) {
	const color = getRatingColor(rating);
	const label = getRatingLabel(rating);
	return /* @__PURE__ */ jsxs("div", {
		className: "flex flex-col gap-2",
		children: [/* @__PURE__ */ jsxs("div", {
			className: "flex items-center gap-3",
			children: [
				/* @__PURE__ */ jsx("div", {
					className: "relative w-full max-w-xs",
					children: /* @__PURE__ */ jsx("div", {
						className: "h-2.5 rounded-full bg-default/40 overflow-hidden",
						children: /* @__PURE__ */ jsx("div", {
							className: `h-full rounded-full transition-all duration-500 ${getRatingTailwindColor(rating)}`,
							style: { width: `${rating * 10}%` }
						})
					})
				}),
				/* @__PURE__ */ jsx("span", {
					className: "text-lg font-bold tabular-nums min-w-[2ch] text-right",
					children: rating
				}),
				/* @__PURE__ */ jsx("span", {
					className: "text-sm text-muted",
					children: "/10"
				})
			]
		}), showLabel && /* @__PURE__ */ jsx(Chip, {
			color,
			size,
			variant: "soft",
			children: label
		})]
	});
}
//#endregion
//#region resources/js/Components/ProductCard.jsx
function ProductCard({ product, searchQuery = "" }) {
	const ratingColor = getRatingColor(product.rating);
	const ratingLabel = getRatingLabel(product.rating);
	const barColor = getRatingTailwindColor(product.rating);
	const handleClick = () => {
		localStorage.setItem("searchQuery", searchQuery);
		localStorage.setItem("searchScrollY", String(window.scrollY));
	};
	return /* @__PURE__ */ jsx(Link$1, {
		href: `/products/${product.slug}`,
		onClick: handleClick,
		children: /* @__PURE__ */ jsxs(Card, {
			className: "h-full hover:shadow-lg transition-shadow duration-200 cursor-pointer",
			children: [
				product.image_path ? /* @__PURE__ */ jsx("div", {
					className: "aspect-video overflow-hidden rounded-t-2xl",
					children: /* @__PURE__ */ jsx("img", {
						src: product.image_path,
						alt: product.name,
						className: "w-full h-full object-cover"
					})
				}) : /* @__PURE__ */ jsx("div", {
					className: "aspect-video bg-default-200 flex items-center justify-center rounded-t-2xl",
					children: /* @__PURE__ */ jsx("span", {
						className: "text-default-500 text-lg font-medium px-4 text-center line-clamp-2",
						children: product.name
					})
				}),
				/* @__PURE__ */ jsx(Card.Header, { children: /* @__PURE__ */ jsxs("div", {
					className: "flex items-start justify-between gap-2 w-full",
					children: [/* @__PURE__ */ jsxs("div", {
						className: "flex-1 min-w-0",
						children: [/* @__PURE__ */ jsx(Card.Title, {
							className: "text-base truncate",
							children: product.name
						}), /* @__PURE__ */ jsx(Card.Description, {
							className: "text-sm",
							children: product.company?.name
						})]
					}), /* @__PURE__ */ jsxs(Chip, {
						color: ratingColor,
						size: "sm",
						variant: "soft",
						children: [product.rating, "/10"]
					})]
				}) }),
				/* @__PURE__ */ jsx(Card.Content, { children: /* @__PURE__ */ jsxs("div", {
					className: "flex flex-col gap-2",
					children: [
						/* @__PURE__ */ jsx("div", {
							className: "flex items-center gap-2",
							children: /* @__PURE__ */ jsx("div", {
								className: "flex-1 h-2 rounded-full bg-default/40 overflow-hidden",
								children: /* @__PURE__ */ jsx("div", {
									className: `h-full rounded-full ${barColor}`,
									style: { width: `${product.rating * 10}%` }
								})
							})
						}),
						/* @__PURE__ */ jsx("span", {
							className: "text-xs text-muted",
							children: ratingLabel
						}),
						product.serial_number && /* @__PURE__ */ jsxs("span", {
							className: "text-xs text-muted font-mono",
							children: ["SN: ", product.serial_number]
						})
					]
				}) })
			]
		})
	});
}
//#endregion
//#region resources/js/Components/FilterSort.jsx
var FilterSort_default = memo(function FilterSort({ onSortChange, onMinRatingChange }) {
	const [sort, setSort] = useState("rating_desc");
	const [minRating, setMinRating] = useState(0);
	const handleSortChange = useCallback((value) => {
		setSort(value);
		onSortChange(value);
	}, [onSortChange]);
	const handleRatingChange = useCallback((value) => {
		const val = Array.isArray(value) ? value[0] : value;
		setMinRating(val);
		onMinRatingChange(val);
	}, [onMinRatingChange]);
	return /* @__PURE__ */ jsxs("div", {
		className: "flex flex-wrap items-end gap-4",
		children: [/* @__PURE__ */ jsxs(Select, {
			className: "w-56",
			value: sort,
			onChange: handleSortChange,
			children: [
				/* @__PURE__ */ jsx(Label, { children: "Sort by" }),
				/* @__PURE__ */ jsxs(Select.Trigger, { children: [/* @__PURE__ */ jsx(Select.Value, {}), /* @__PURE__ */ jsx(Select.Indicator, {})] }),
				/* @__PURE__ */ jsx(Select.Popover, { children: /* @__PURE__ */ jsxs(ListBox, { children: [
					/* @__PURE__ */ jsxs(ListBox.Item, {
						id: "rating_desc",
						textValue: "Rating (high to low)",
						children: ["Rating (high to low)", /* @__PURE__ */ jsx(ListBox.ItemIndicator, {})]
					}),
					/* @__PURE__ */ jsxs(ListBox.Item, {
						id: "rating_asc",
						textValue: "Rating (low to high)",
						children: ["Rating (low to high)", /* @__PURE__ */ jsx(ListBox.ItemIndicator, {})]
					}),
					/* @__PURE__ */ jsxs(ListBox.Item, {
						id: "name_asc",
						textValue: "Name (A-Z)",
						children: ["Name (A-Z)", /* @__PURE__ */ jsx(ListBox.ItemIndicator, {})]
					}),
					/* @__PURE__ */ jsxs(ListBox.Item, {
						id: "name_desc",
						textValue: "Name (Z-A)",
						children: ["Name (Z-A)", /* @__PURE__ */ jsx(ListBox.ItemIndicator, {})]
					})
				] }) })
			]
		}), /* @__PURE__ */ jsxs(Slider, {
			className: "w-64",
			minValue: 0,
			maxValue: 10,
			step: 1,
			value: minRating,
			onChange: handleRatingChange,
			children: [
				/* @__PURE__ */ jsxs(Label, { children: [
					"Min rating: ",
					minRating,
					"/10"
				] }),
				/* @__PURE__ */ jsx(Slider.Output, {}),
				/* @__PURE__ */ jsxs(Slider.Track, { children: [/* @__PURE__ */ jsx(Slider.Fill, {}), /* @__PURE__ */ jsx(Slider.Thumb, {})] })
			]
		})]
	});
});
//#endregion
//#region resources/js/Pages/Company.jsx
var Company_exports = /* @__PURE__ */ __exportAll({ default: () => Company });
function Company({ company, averageRating }) {
	const [sort, setSort] = useState("rating_desc");
	const [minRating, setMinRating] = useState(0);
	const filteredProducts = useMemo(() => {
		let products = [...company.products];
		if (minRating > 0) products = products.filter((p) => p.rating >= minRating);
		const sortFns = {
			rating_desc: (a, b) => b.rating - a.rating,
			rating_asc: (a, b) => a.rating - b.rating,
			name_asc: (a, b) => a.name.localeCompare(b.name),
			name_desc: (a, b) => b.name.localeCompare(a.name)
		};
		if (sortFns[sort]) products.sort(sortFns[sort]);
		return products;
	}, [
		company.products,
		sort,
		minRating
	]);
	return /* @__PURE__ */ jsx(AppLayout, { children: /* @__PURE__ */ jsxs("div", {
		className: "max-w-6xl mx-auto px-4 py-8 space-y-8",
		children: [/* @__PURE__ */ jsxs("div", {
			className: "space-y-4",
			children: [
				/* @__PURE__ */ jsx("button", {
					onClick: () => window.history.back(),
					className: "inline-flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors cursor-pointer",
					children: "← Back"
				}),
				/* @__PURE__ */ jsx("h1", {
					className: "text-2xl sm:text-3xl font-bold tracking-tight",
					children: company.name
				}),
				company.description && /* @__PURE__ */ jsx("p", {
					className: "text-foreground/70 max-w-2xl",
					children: company.description
				}),
				company.website_url && /* @__PURE__ */ jsx(Link, {
					href: company.website_url,
					isExternal: true,
					showAnchorIcon: true,
					className: "text-sm",
					children: company.website_url
				}),
				/* @__PURE__ */ jsx(Card, {
					className: "p-6",
					children: /* @__PURE__ */ jsxs("div", {
						className: "space-y-3",
						children: [
							/* @__PURE__ */ jsx("h2", {
								className: "text-sm font-semibold text-muted uppercase tracking-wide",
								children: "Average Suspicion Score"
							}),
							/* @__PURE__ */ jsxs("div", {
								className: "flex items-center gap-4",
								children: [/* @__PURE__ */ jsx("span", {
									className: "text-4xl font-bold",
									children: averageRating
								}), /* @__PURE__ */ jsx("span", {
									className: "text-muted",
									children: "/ 10"
								})]
							}),
							/* @__PURE__ */ jsx(RatingIndicator, {
								rating: Math.round(averageRating),
								size: "md"
							}),
							/* @__PURE__ */ jsxs("p", {
								className: "text-xs text-muted",
								children: [
									"Based on ",
									company.products.length,
									" product",
									company.products.length !== 1 ? "s" : ""
								]
							})
						]
					})
				})
			]
		}), /* @__PURE__ */ jsxs("div", {
			className: "space-y-4",
			children: [
				/* @__PURE__ */ jsxs("h2", {
					className: "text-lg font-semibold",
					children: ["Products", /* @__PURE__ */ jsxs("span", {
						className: "text-sm font-normal text-muted ml-2",
						children: [
							"(",
							filteredProducts.length,
							")"
						]
					})]
				}),
				/* @__PURE__ */ jsx(FilterSort_default, {
					onSortChange: setSort,
					onMinRatingChange: setMinRating
				}),
				filteredProducts.length > 0 ? /* @__PURE__ */ jsx("div", {
					className: "grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4",
					children: filteredProducts.map((product) => /* @__PURE__ */ jsx(ProductCard, { product }, product.id))
				}) : /* @__PURE__ */ jsx("p", {
					className: "text-muted text-center py-8",
					children: "No products match the current filters."
				})
			]
		})]
	}) });
}
//#endregion
//#region resources/js/Pages/Home.jsx
var Home_exports = /* @__PURE__ */ __exportAll({ default: () => Home });
function Home() {
	const [query, setQuery] = useState("");
	const [results, setResults] = useState([]);
	const [loading, setLoading] = useState(false);
	const [loadingMore, setLoadingMore] = useState(false);
	const [searched, setSearched] = useState(false);
	const [meta, setMeta] = useState(null);
	const [sort, setSort] = useState("rating_desc");
	const [minRating, setMinRating] = useState(0);
	const abortRef = useRef(null);
	const abortMoreRef = useRef(null);
	const debounceRef = useRef(null);
	const restoredRef = useRef(false);
	const currentPageRef = useRef(1);
	const sentinelRef = useRef(null);
	const doSearch = useCallback((q, page = 1, currentSort, currentMinRating) => {
		if (q.trim().length < 2) {
			setResults([]);
			setSearched(false);
			setMeta(null);
			return;
		}
		if (page === 1 && abortRef.current) abortRef.current.abort();
		if (page > 1 && abortMoreRef.current) abortMoreRef.current.abort();
		const controller = new AbortController();
		if (page === 1) abortRef.current = controller;
		else abortMoreRef.current = controller;
		if (page === 1) setLoading(true);
		else setLoadingMore(true);
		setSearched(true);
		currentPageRef.current = page;
		const params = new URLSearchParams({
			q: q.trim(),
			page: String(page),
			sort: currentSort || "rating_desc"
		});
		if (currentMinRating && currentMinRating > 0) params.set("min_rating", String(currentMinRating));
		fetch(`/search?${params.toString()}`, { signal: controller.signal }).then((res) => res.json()).then((data) => {
			if (page === 1) setResults(data.data);
			else setResults((prev) => [...prev, ...data.data]);
			setMeta(data.meta);
			setLoading(false);
			setLoadingMore(false);
			if (restoredRef.current) {
				restoredRef.current = false;
				const scrollY = localStorage.getItem("searchScrollY");
				if (scrollY) requestAnimationFrame(() => {
					window.scrollTo(0, parseInt(scrollY, 10));
				});
				localStorage.removeItem("searchScrollY");
			}
		}).catch((err) => {
			if (err.name !== "AbortError") {
				setLoading(false);
				setLoadingMore(false);
			}
		});
	}, []);
	useEffect(() => {
		const savedQuery = localStorage.getItem("searchQuery");
		if (savedQuery) {
			localStorage.removeItem("searchQuery");
			restoredRef.current = true;
			setQuery(savedQuery);
		}
	}, []);
	useEffect(() => {
		if (debounceRef.current) clearTimeout(debounceRef.current);
		if (query.trim().length < 2) {
			setResults([]);
			setSearched(false);
			setMeta(null);
			currentPageRef.current = 1;
			return;
		}
		currentPageRef.current = 1;
		debounceRef.current = setTimeout(() => {
			doSearch(query, 1, sort, minRating);
		}, 300);
		return () => {
			if (debounceRef.current) clearTimeout(debounceRef.current);
		};
	}, [
		query,
		sort,
		minRating,
		doSearch
	]);
	const hasMore = meta && meta.current_page < meta.last_page;
	useEffect(() => {
		if (!sentinelRef.current || !hasMore || loadingMore) return;
		const observer = new IntersectionObserver((entries) => {
			if (entries[0].isIntersecting && hasMore && !loadingMore && !loading) doSearch(query, currentPageRef.current + 1, sort, minRating);
		}, { rootMargin: "200px" });
		observer.observe(sentinelRef.current);
		return () => observer.disconnect();
	}, [
		hasMore,
		loadingMore,
		loading,
		query,
		sort,
		minRating,
		doSearch
	]);
	return /* @__PURE__ */ jsxs(AppLayout, { children: [/* @__PURE__ */ jsx("div", {
		className: "flex flex-col items-center px-4 pt-16 pb-8",
		children: /* @__PURE__ */ jsxs("div", {
			className: "max-w-2xl w-full text-center space-y-8",
			children: [
				/* @__PURE__ */ jsxs("div", {
					className: "space-y-4",
					children: [/* @__PURE__ */ jsxs("h1", {
						className: "text-4xl sm:text-5xl font-bold tracking-tight",
						children: [
							"Is It ",
							/* @__PURE__ */ jsx("span", {
								className: "text-danger",
								children: "Private Label"
							}),
							"?"
						]
					}), /* @__PURE__ */ jsx("p", {
						className: "text-lg text-muted max-w-lg mx-auto",
						children: "Search for a company, product, or serial number to check if it might be a private-labeled product."
					})]
				}),
				/* @__PURE__ */ jsx("div", {
					className: "w-full max-w-xl mx-auto",
					children: /* @__PURE__ */ jsxs(SearchField, {
						name: "search",
						value: query,
						onChange: setQuery,
						children: [/* @__PURE__ */ jsx(Label, { children: "Search" }), /* @__PURE__ */ jsxs(SearchField.Group, { children: [
							/* @__PURE__ */ jsx(SearchField.SearchIcon, {}),
							/* @__PURE__ */ jsx(SearchField.Input, {
								className: "w-full",
								placeholder: "Company name, product, or serial number..."
							}),
							/* @__PURE__ */ jsx(SearchField.ClearButton, {})
						] })]
					})
				}),
				!searched && /* @__PURE__ */ jsxs("div", {
					className: "flex flex-wrap justify-center gap-3 text-sm text-muted",
					children: [
						/* @__PURE__ */ jsx("span", { children: "Try:" }),
						/* @__PURE__ */ jsx("button", {
							onClick: () => setQuery("TechNova"),
							className: "text-foreground/70 hover:text-foreground underline underline-offset-2 transition-colors",
							children: "TechNova"
						}),
						/* @__PURE__ */ jsx("button", {
							onClick: () => setQuery("sunset lamp"),
							className: "text-foreground/70 hover:text-foreground underline underline-offset-2 transition-colors",
							children: "sunset lamp"
						}),
						/* @__PURE__ */ jsx("button", {
							onClick: () => setQuery("AliExpress"),
							className: "text-foreground/70 hover:text-foreground underline underline-offset-2 transition-colors",
							children: "AliExpress"
						})
					]
				})
			]
		})
	}), searched && /* @__PURE__ */ jsx("div", {
		className: "max-w-6xl mx-auto px-4 pb-16",
		children: loading ? /* @__PURE__ */ jsx("div", {
			className: "text-center py-12",
			children: /* @__PURE__ */ jsx(Spinner, { size: "lg" })
		}) : results.length > 0 ? /* @__PURE__ */ jsxs("div", {
			className: "space-y-4",
			children: [
				/* @__PURE__ */ jsxs("p", {
					className: "text-sm text-muted text-center",
					children: [
						"Found ",
						/* @__PURE__ */ jsx("strong", {
							className: "text-foreground",
							children: meta?.total ?? results.length
						}),
						" result",
						(meta?.total ?? results.length) !== 1 ? "s" : ""
					]
				}),
				/* @__PURE__ */ jsx("div", {
					className: "flex justify-center",
					children: /* @__PURE__ */ jsx(FilterSort_default, {
						onSortChange: setSort,
						onMinRatingChange: setMinRating
					})
				}),
				/* @__PURE__ */ jsx("div", {
					className: "grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4",
					children: results.map((product) => /* @__PURE__ */ jsx(ProductCard, {
						product,
						searchQuery: query
					}, product.id))
				}),
				/* @__PURE__ */ jsx("div", {
					ref: sentinelRef,
					className: "h-1"
				}),
				loadingMore && /* @__PURE__ */ jsx("div", {
					className: "text-center py-6",
					children: /* @__PURE__ */ jsx(Spinner, { size: "md" })
				})
			]
		}) : /* @__PURE__ */ jsxs("div", {
			className: "text-center py-12 space-y-2",
			children: [/* @__PURE__ */ jsx("p", {
				className: "text-3xl",
				children: "🔍"
			}), /* @__PURE__ */ jsxs("p", {
				className: "text-muted",
				children: [
					"No results found for \"",
					/* @__PURE__ */ jsx("strong", {
						className: "text-foreground",
						children: query
					}),
					"\""
				]
			})]
		})
	})] });
}
//#endregion
//#region resources/js/Pages/OurMission.jsx
var OurMission_exports = /* @__PURE__ */ __exportAll({ default: () => OurMission });
function OurMission() {
	return /* @__PURE__ */ jsx(AppLayout, { children: /* @__PURE__ */ jsxs("div", {
		className: "max-w-3xl mx-auto px-4 py-16 space-y-8",
		children: [/* @__PURE__ */ jsxs("h1", {
			className: "text-4xl font-bold tracking-tight",
			children: ["Our ", /* @__PURE__ */ jsx("span", {
				className: "text-danger",
				children: "Mission"
			})]
		}), /* @__PURE__ */ jsxs("div", {
			className: "space-y-6 text-muted leading-relaxed",
			children: [
				/* @__PURE__ */ jsx("p", { children: "IsItPrivateLabel.org exists to bring transparency to the marketplace. We believe consumers deserve to know when a product they are considering is not what it appears to be." }),
				/* @__PURE__ */ jsx("h2", {
					className: "text-2xl font-semibold text-foreground",
					children: "What We Do"
				}),
				/* @__PURE__ */ jsx("p", { children: "We research and catalog products that are suspected of being private-labeled — items manufactured by one company and sold under another's brand. By collecting publicly available evidence, we assign a suspicion score to help you gauge how likely a product is to be a relabeled generic." }),
				/* @__PURE__ */ jsx("h2", {
					className: "text-2xl font-semibold text-foreground",
					children: "How We Score"
				}),
				/* @__PURE__ */ jsx("p", { children: "Our ratings range from 1 to 9, where higher scores indicate stronger evidence that a product is private-labeled. These scores are based on publicly available information such as manufacturer listings, packaging similarities, and supply chain data." }),
				/* @__PURE__ */ jsx("h2", {
					className: "text-2xl font-semibold text-foreground",
					children: "Our Principles"
				}),
				/* @__PURE__ */ jsxs("ul", {
					className: "list-disc list-inside space-y-2",
					children: [
						/* @__PURE__ */ jsxs("li", { children: [/* @__PURE__ */ jsx("strong", {
							className: "text-foreground",
							children: "Transparency:"
						}), " All our evidence is publicly sourced and traceable. The code is open source, and the data are open."] }),
						/* @__PURE__ */ jsxs("li", { children: [/* @__PURE__ */ jsx("strong", {
							className: "text-foreground",
							children: "Fairness:"
						}), " We are not against private-label products. This website aims to warn customers before buying potentially misleading products. Every company can make a claim on the product page if the product is badly noted."] }),
						/* @__PURE__ */ jsxs("li", { children: [/* @__PURE__ */ jsx("strong", {
							className: "text-foreground",
							children: "Accuracy:"
						}), " Our scores reflect evidence levels, not definitive claims."] })
					]
				})
			]
		})]
	}) });
}
//#endregion
//#region resources/js/Components/PlatformLink.jsx
function PlatformLink({ link }) {
	const label = getPlatformLabel(link.platform);
	return /* @__PURE__ */ jsxs("div", {
		className: "flex items-center gap-3",
		children: [/* @__PURE__ */ jsx(Chip, {
			color: getPlatformColor(link.platform),
			size: "sm",
			variant: "flat",
			children: label
		}), /* @__PURE__ */ jsx(Link, {
			href: link.url,
			isExternal: true,
			showAnchorIcon: true,
			className: "text-sm",
			children: link.label || link.url
		})]
	});
}
//#endregion
//#region resources/js/Components/ProofItem.jsx
function ProofItem({ proof }) {
	return /* @__PURE__ */ jsxs(Card, {
		variant: "transparent",
		className: "border border-default/40",
		children: [/* @__PURE__ */ jsx(Card.Header, { children: /* @__PURE__ */ jsxs("div", {
			className: "flex items-center gap-2",
			children: [
				/* @__PURE__ */ jsx("span", {
					className: "text-sm",
					children: {
						text: "📝",
						image: "🖼️",
						link: "🔗",
						file: "📄"
					}[proof.type] || "📎"
				}),
				/* @__PURE__ */ jsx(Chip, {
					size: "sm",
					variant: "flat",
					color: "default",
					children: proof.type.charAt(0).toUpperCase() + proof.type.slice(1)
				}),
				proof.description && /* @__PURE__ */ jsx("span", {
					className: "text-sm text-muted",
					children: proof.description
				})
			]
		}) }), /* @__PURE__ */ jsxs(Card.Content, { children: [
			proof.type === "text" && /* @__PURE__ */ jsx("p", {
				className: "text-sm text-foreground/80 leading-relaxed",
				children: proof.content
			}),
			proof.type === "image" && /* @__PURE__ */ jsx("img", {
				src: proof.content,
				alt: proof.description || "Proof image",
				className: "max-w-full h-auto rounded-lg max-h-64 object-contain"
			}),
			proof.type === "link" && /* @__PURE__ */ jsx(Link, {
				href: proof.content,
				isExternal: true,
				showAnchorIcon: true,
				className: "text-sm",
				children: proof.description || proof.content
			}),
			proof.type === "file" && /* @__PURE__ */ jsx(Link, {
				href: proof.content,
				isExternal: true,
				showAnchorIcon: true,
				className: "text-sm",
				children: "Download file"
			})
		] })]
	});
}
//#endregion
//#region resources/js/Pages/Product.jsx
var Product_exports = /* @__PURE__ */ __exportAll({ default: () => Product });
function Product({ product }) {
	return /* @__PURE__ */ jsx(AppLayout, { children: /* @__PURE__ */ jsxs("div", {
		className: "max-w-4xl mx-auto px-4 py-8 space-y-8",
		children: [
			/* @__PURE__ */ jsxs("div", {
				className: "space-y-6",
				children: [
					/* @__PURE__ */ jsx("button", {
						onClick: () => window.history.back(),
						className: "inline-flex items-center gap-1.5 text-sm text-muted hover:text-foreground transition-colors cursor-pointer",
						children: "← Back to results"
					}),
					/* @__PURE__ */ jsxs("div", {
						className: "flex flex-col sm:flex-row gap-6 items-start",
						children: [product.image_path && /* @__PURE__ */ jsx("div", {
							className: "w-full sm:w-48 shrink-0",
							children: /* @__PURE__ */ jsx("img", {
								src: product.image_path,
								alt: product.name,
								className: "w-full h-auto rounded-2xl object-cover"
							})
						}), /* @__PURE__ */ jsxs("div", {
							className: "flex-1 space-y-3",
							children: [
								/* @__PURE__ */ jsx("h1", {
									className: "text-2xl sm:text-3xl font-bold tracking-tight",
									children: product.name
								}),
								/* @__PURE__ */ jsxs("div", {
									className: "flex items-center gap-2 text-sm text-muted",
									children: [/* @__PURE__ */ jsx("span", { children: "by" }), /* @__PURE__ */ jsx(Link$1, {
										href: `/companies/${product.company?.slug}`,
										className: "text-foreground font-medium hover:underline",
										children: product.company?.name
									})]
								}),
								product.serial_number && /* @__PURE__ */ jsxs("p", {
									className: "text-sm text-muted font-mono",
									children: ["Serial: ", product.serial_number]
								}),
								product.description && /* @__PURE__ */ jsx("p", {
									className: "text-sm text-foreground/70 leading-relaxed",
									children: product.description
								})
							]
						})]
					}),
					/* @__PURE__ */ jsx(Card, {
						className: "p-6",
						children: /* @__PURE__ */ jsxs("div", {
							className: "space-y-3",
							children: [/* @__PURE__ */ jsx("h2", {
								className: "text-sm font-semibold text-muted uppercase tracking-wide",
								children: "Private Label Suspicion Score"
							}), /* @__PURE__ */ jsx(RatingIndicator, {
								rating: product.rating,
								size: "lg"
							})]
						})
					})
				]
			}),
			product.links && product.links.length > 0 && /* @__PURE__ */ jsxs("div", {
				className: "space-y-4",
				children: [/* @__PURE__ */ jsx("h2", {
					className: "text-lg font-semibold",
					children: "External Links"
				}), /* @__PURE__ */ jsx(Card, {
					className: "p-4",
					children: /* @__PURE__ */ jsxs("div", {
						className: "space-y-3",
						children: [product.links.map((link) => /* @__PURE__ */ jsx(PlatformLink, { link }, link.id)), product.company_url && /* @__PURE__ */ jsxs("div", {
							className: "flex items-center gap-3",
							children: [/* @__PURE__ */ jsx(Chip, {
								color: "default",
								size: "sm",
								variant: "flat",
								children: "Company"
							}), /* @__PURE__ */ jsx(Link, {
								href: product.company_url,
								isExternal: true,
								showAnchorIcon: true,
								className: "text-sm",
								children: "View on company website"
							})]
						})]
					})
				})]
			}),
			product.proofs && product.proofs.length > 0 && /* @__PURE__ */ jsxs("div", {
				className: "space-y-4",
				children: [/* @__PURE__ */ jsxs("h2", {
					className: "text-lg font-semibold",
					children: ["Evidence & Proofs", /* @__PURE__ */ jsxs("span", {
						className: "text-sm font-normal text-muted ml-2",
						children: [
							"(",
							product.proofs.length,
							")"
						]
					})]
				}), /* @__PURE__ */ jsx("div", {
					className: "space-y-3",
					children: product.proofs.map((proof) => /* @__PURE__ */ jsx(ProofItem, { proof }, proof.id))
				})]
			}),
			/* @__PURE__ */ jsx("div", {
				className: "text-center pt-4",
				children: /* @__PURE__ */ jsxs(Link$1, {
					href: `/companies/${product.company?.slug}`,
					className: "text-sm text-muted hover:text-foreground transition-colors",
					children: [
						"View all products from ",
						product.company?.name,
						" →"
					]
				})
			})
		]
	}) });
}
//#endregion
//#region resources/js/Pages/Welcome.jsx
var Welcome_exports = /* @__PURE__ */ __exportAll({ default: () => Hello });
function Hello() {
	return /* @__PURE__ */ jsx("div", { children: "Hello" });
}
//#endregion
//#region resources/js/Pages/WhatIsPrivateLabel.jsx
var WhatIsPrivateLabel_exports = /* @__PURE__ */ __exportAll({ default: () => WhatIsPrivateLabel });
function WhatIsPrivateLabel() {
	return /* @__PURE__ */ jsx(AppLayout, { children: /* @__PURE__ */ jsxs("div", {
		className: "max-w-3xl mx-auto px-4 py-16 space-y-8",
		children: [/* @__PURE__ */ jsxs("h1", {
			className: "text-4xl font-bold tracking-tight",
			children: [
				"What is ",
				/* @__PURE__ */ jsx("span", {
					className: "text-danger",
					children: "Private Label"
				}),
				"?"
			]
		}), /* @__PURE__ */ jsxs("div", {
			className: "space-y-6 text-muted leading-relaxed",
			children: [
				/* @__PURE__ */ jsx("p", { children: "Private label products are manufactured by one company and sold under another company's brand name. Also known as store brands or generic brands, these products are designed to look like they come from a unique or independent manufacturer, but are actually produced by a third-party supplier." }),
				/* @__PURE__ */ jsx("h2", {
					className: "text-2xl font-semibold text-foreground",
					children: "How It Works"
				}),
				/* @__PURE__ */ jsx("p", { children: "A retailer or distributor contracts with a manufacturer to produce goods according to their specifications. The manufacturer then packages and labels the product under the buyer's brand. This allows companies to offer products that appear exclusive to their store or brand, often at lower prices than name-brand alternatives." }),
				/* @__PURE__ */ jsx("h2", {
					className: "text-2xl font-semibold text-foreground",
					children: "Why It Matters"
				}),
				/* @__PURE__ */ jsx("p", { children: "Private labeling is widespread across industries — from electronics and supplements to cosmetics and food products. While not inherently bad, the practice can be misleading when consumers believe they are buying from an independent brand when the same product is sold by many companies under different names." }),
				/* @__PURE__ */ jsx("p", { children: "Understanding which products are private-labeled helps consumers make more informed purchasing decisions and identify when they are paying a premium for branding rather than quality or uniqueness." })
			]
		})]
	}) });
}
//#endregion
//#region resources/js/app.jsx
var pages = /* #__PURE__ */ Object.assign({
	"./Pages/Company.jsx": Company_exports,
	"./Pages/Home.jsx": Home_exports,
	"./Pages/OurMission.jsx": OurMission_exports,
	"./Pages/Product.jsx": Product_exports,
	"./Pages/Welcome.jsx": Welcome_exports,
	"./Pages/WhatIsPrivateLabel.jsx": WhatIsPrivateLabel_exports
});
var render = await createInertiaApp({
	resolve: (name) => {
		return pages[`./Pages/${name}.jsx`].default;
	},
	setup({ el, App, props }) {
		if (!el) return;
		createRoot(el).render(/* @__PURE__ */ jsx(App, { ...props }));
	}
});
var renderPage = (page) => render(page, renderToString);
createServer(renderPage);
//#endregion
export { renderPage as default };

//# sourceMappingURL=app.js.map