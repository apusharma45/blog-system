<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" {{ $attributes }}>
    <!-- Outer Circle Background -->
    <circle cx="24" cy="24" r="22" fill="currentColor" opacity="0.1"/>
    
    <!-- Main Document -->
    <path 
        d="M16 10C16 8.89543 16.8954 8 18 8H26L34 16V36C34 37.1046 33.1046 38 32 38H18C16.8954 38 16 37.1046 16 36V10Z" 
        fill="currentColor"
        opacity="0.9"
    />
    
    <!-- Document Corner Fold -->
    <path 
        d="M26 8V14C26 15.1046 26.8954 16 28 16H34L26 8Z" 
        fill="currentColor"
        opacity="0.6"
    />
    
    <!-- Feather Quill Pen -->
    <g transform="translate(20, 20) rotate(-15)">
        <!-- Pen Body -->
        <path 
            d="M14 2L8 8L9.5 9.5L15.5 3.5L14 2Z" 
            fill="currentColor"
        />
        <!-- Pen Tip -->
        <path 
            d="M8 8L6 14L8.5 11.5L9.5 9.5L8 8Z" 
            fill="currentColor"
        />
        <!-- Feather Detail -->
        <path 
            d="M14.5 2.5C15.5 2 16.5 2 17 2.5C17.2 3 17 4 16.5 4.5L15.5 3.5L14.5 2.5Z" 
            fill="currentColor"
            opacity="0.7"
        />
    </g>
    
    <!-- Document Lines (Text) -->
    <rect x="19" y="18" width="8" height="1.5" rx="0.75" fill="currentColor" opacity="0.4"/>
    <rect x="19" y="22" width="10" height="1.5" rx="0.75" fill="currentColor" opacity="0.3"/>
    <rect x="19" y="26" width="6" height="1.5" rx="0.75" fill="currentColor" opacity="0.3"/>
    
    <!-- Sparkle/Star Accent -->
    <circle cx="38" cy="12" r="2" fill="currentColor" opacity="0.6"/>
    <path d="M38 9V15M35 12H41" stroke="currentColor" stroke-width="1.5" opacity="0.6"/>
</svg>
