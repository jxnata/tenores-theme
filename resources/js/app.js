class Carousel {
	constructor(rootElement, options = {}) {
		this.rootElement = rootElement
		this.trackElement = rootElement.querySelector('[data-carousel-track]')
		this.items = Array.from(this.trackElement ? this.trackElement.children : [])

		const visibleFromData = parseInt(rootElement.dataset.carouselVisible || '', 10)
		const stepFromData = parseInt(rootElement.dataset.carouselStep || '', 10)
		const intervalFromData = parseInt(rootElement.dataset.carouselInterval || '', 10)

		this.hasFixedVisibleItems = !Number.isNaN(visibleFromData)
		this.defaultVisibleItems = this.hasFixedVisibleItems ? visibleFromData : options.visibleItems || 1
		this.visibleItems = this.defaultVisibleItems
		this.step = !Number.isNaN(stepFromData) ? stepFromData : options.step || 1
		this.interval = !Number.isNaN(intervalFromData) ? intervalFromData : options.interval || 3000

		this.totalItems = this.items.length
		this.maxIndex = Math.max(0, this.totalItems - this.visibleItems)
		this.currentIndex = 0

		this.paginationContainer = rootElement.querySelector('[data-carousel-pagination]')
		this.dots = []
		this.autoPlayTimer = null

		this.breakpoints = {
			lg: options.breakpoints && options.breakpoints.lg ? options.breakpoints.lg : 4,
			md: options.breakpoints && options.breakpoints.md ? options.breakpoints.md : 3,
			sm: options.breakpoints && options.breakpoints.sm ? options.breakpoints.sm : 2,
			xs: options.breakpoints && options.breakpoints.xs ? options.breakpoints.xs : 1,
		}

		if (this.totalItems === 0 || !this.trackElement) {
			return
		}

		this.initialize()
	}

	initialize() {
		if (!this.hasFixedVisibleItems) {
			this.updateResponsiveVisibleItems()
		}
		this.maxIndex = Math.max(0, this.totalItems - this.visibleItems)

		this.items.forEach((item) => {
			const flexBasis = this.visibleItems === 1 ? '100%' : `${100 / this.visibleItems}%`
			item.style.flex = `0 0 ${flexBasis}`
		})

		this.createPagination()
		this.update()
		this.startAutoPlay()

		this.rootElement.addEventListener('mouseenter', () => {
			this.stopAutoPlay()
		})

		this.rootElement.addEventListener('mouseleave', () => {
			this.startAutoPlay()
		})

		window.addEventListener('resize', () => {
			if (this.hasFixedVisibleItems) {
				return
			}

			const previousVisibleItems = this.visibleItems
			this.updateResponsiveVisibleItems()

			if (this.visibleItems !== previousVisibleItems) {
				this.maxIndex = Math.max(0, this.totalItems - this.visibleItems)
				if (this.currentIndex > this.maxIndex) {
					this.currentIndex = this.maxIndex
				}
				this.createPagination()
			}

			this.items.forEach((item) => {
				const flexBasis = this.visibleItems === 1 ? '100%' : `${100 / this.visibleItems}%`
				item.style.flex = `0 0 ${flexBasis}`
			})
			this.update()
		})
	}

	updateResponsiveVisibleItems() {
		const viewportWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth

		if (viewportWidth >= 1024) {
			this.visibleItems = this.breakpoints.lg
		} else if (viewportWidth >= 768) {
			this.visibleItems = this.breakpoints.md
		} else if (viewportWidth >= 640) {
			this.visibleItems = this.breakpoints.sm
		} else {
			this.visibleItems = this.breakpoints.xs
		}
	}

	createPagination() {
		if (!this.paginationContainer) {
			return
		}

		this.paginationContainer.innerHTML = ''
		this.dots = []

		const totalPages = this.maxIndex + 1

		for (let pageIndex = 0; pageIndex < totalPages; pageIndex += 1) {
			const button = document.createElement('button')
			button.type = 'button'
			button.className = 'carousel-dot'
			button.setAttribute('aria-label', `Ir para os benefícios ${pageIndex + 1}`)

			button.addEventListener('click', () => {
				this.goTo(pageIndex)
			})

			this.paginationContainer.appendChild(button)
			this.dots.push(button)
		}
	}

	goTo(index) {
		if (this.maxIndex === 0) {
			this.currentIndex = 0
		} else {
			const normalizedIndex = ((index % (this.maxIndex + 1)) + (this.maxIndex + 1)) % (this.maxIndex + 1)
			this.currentIndex = normalizedIndex
		}

		this.update()
	}

	next() {
		this.goTo(this.currentIndex + this.step)
	}

	startAutoPlay() {
		if (this.interval <= 0 || this.maxIndex === 0) {
			return
		}

		this.stopAutoPlay()

		this.autoPlayTimer = window.setInterval(() => {
			this.next()
		}, this.interval)
	}

	stopAutoPlay() {
		if (this.autoPlayTimer) {
			window.clearInterval(this.autoPlayTimer)
			this.autoPlayTimer = null
		}
	}

	update() {
		const translatePercentage = (100 / this.visibleItems) * this.currentIndex
		this.trackElement.style.transform = `translateX(-${translatePercentage}%)`

		if (this.dots.length > 0) {
			this.dots.forEach((dot, index) => {
				if (index === this.currentIndex) {
					dot.classList.add('is-active')
				} else {
					dot.classList.remove('is-active')
				}
			})
		}
	}
}

window.addEventListener('load', () => {
	lucide.createIcons()

	const mainNavigation = document.getElementById('primary-navigation')
	const mainNavigationToggle = document.getElementById('primary-menu-toggle')

	if (mainNavigation && mainNavigationToggle) {
		mainNavigationToggle.addEventListener('click', (event) => {
			event.preventDefault()
			mainNavigation.classList.toggle('hidden')
		})
	}

	const carouselElements = document.querySelectorAll('[data-carousel="true"]')
	carouselElements.forEach((element) => {
		// eslint-disable-next-line no-new
		new Carousel(element, {
			visibleItems: 4,
			step: 1,
			interval: 6000,
		})
	})

	// Atualizar botão flutuante do carrinho
	const updateFloatingCartButton = () => {
		const floatingCartContainer = document.getElementById('floating-cart-container')
		const floatingCartButton = document.querySelector('.floating-cart-button')
		const floatingCartBadge = document.querySelector('.floating-cart-badge')

		if (!floatingCartContainer || !floatingCartButton || !floatingCartBadge) {
			return
		}

		const ajaxUrl = floatingCartContainer.getAttribute('data-ajax-url')

		if (!ajaxUrl) {
			return
		}

		// Fazer requisição AJAX para obter a contagem atualizada do carrinho
		fetch(ajaxUrl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: new URLSearchParams({
				action: 'tenores_get_cart_count',
			}),
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success && data.count !== undefined) {
					const cartCount = parseInt(data.count, 10)

					if (cartCount > 0) {
						floatingCartBadge.textContent = cartCount
						floatingCartBadge.setAttribute('data-cart-count', cartCount)
						floatingCartContainer.style.display = 'block'
					} else {
						floatingCartContainer.style.display = 'none'
					}
				}
			})
			.catch((error) => {
				console.error('Erro ao atualizar contagem do carrinho:', error)
			})
	}

	// Atualizar quando o carrinho é modificado (eventos do WooCommerce)
	if (typeof jQuery !== 'undefined') {
		jQuery(document.body).on('added_to_cart removed_from_cart updated_wc_div', () => {
			updateFloatingCartButton()
		})
	}

	// Atualizar ícones do Lucide após mudanças no DOM
	const observer = new MutationObserver(() => {
		lucide.createIcons()
	})

	const floatingCartButton = document.querySelector('.floating-cart-button')
	if (floatingCartButton) {
		observer.observe(floatingCartButton, {
			childList: true,
			subtree: true,
		})
	}
})
