import { useEffect, useState } from "react"

function Loader({ show }) {
    const [currentShow, setCurrentShow] = useState(false)
    const [out, setOut] = useState(null)

    useEffect(() => {
        if (show && !currentShow) {
            setCurrentShow(true)
            setTimeout(() => {
                clearInterval(out)
                setOut(null)
                setCurrentShow(false)
            }, 1000)
        }
    }, [currentShow, setCurrentShow, show, out, setOut])

    return (
        <div className={'clearfix' + (currentShow ? ' d-block' : ' d-none')}>
            <div className="custom-loader-bg"></div>
            <div className="custom-loader" >
                <img src="/assets/img/loader.gif" alt="Processando..." />
            </div >
        </div >
    )
}

export default Loader