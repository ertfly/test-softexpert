import { useEffect, useState } from "react"

function Modal({ title, visible = true, children, pWidth = 300 }) {
    let [opacity, setOpacity] = useState('0')

    useEffect(() => {
        setOpacity('1.0')
    }, [setOpacity])

    return (
        <>
            {visible ? (
                <>
                    <div className='wrapper-shadow' style={{ opacity: opacity, top: '0', zIndex: '200' }}></div>
                    <div className="wrapper-shadow-scroll" style={{ zIndex: '201' }}>
                        <div className='card wrapper-modal' style={{ opacity: opacity, width: `${pWidth}px`, marginLeft: `-${pWidth / 2}px` }}>
                            <div className="card-header">
                                <h5 className="card-title p-0 m-0">{title}</h5>
                            </div>
                            <div className="card-body">
                                {children}
                            </div>

                        </div>
                    </div>
                </>
            ) : <></>}

        </>
    )
}

export default Modal