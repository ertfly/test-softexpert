import { useEffect, useState } from "react"

function Sidebar({ children, pWidth = '90%' }) {
    let [width, setWidth] = useState('0px')
    let [opacity, setOpacity] = useState('0')

    useEffect(() => {
        setWidth(pWidth)
        setOpacity('1.0')
    }, [setWidth, setOpacity, pWidth])

    return (
        <>
            <div className='wrapper-shadow' style={{ opacity: opacity }}></div>
            <div className='wrapper-sidebar' style={{ width: width, opacity: opacity }}>{children}</div>
        </>
    )
}

export default Sidebar