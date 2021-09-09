using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using BaseDTO;
using Newtonsoft.Json;
namespace BaseDDC.Controllers
{
    [Route("Help")]
    [ApiController]
    public class HelpController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();
        [HttpPost]
        [Route("GetById/{id}")]
        public IActionResult GetByProfileID([FromBody] DTO_Auth_Obj t, int id)
        {
            try
            {
                List<DTO_Help_Get> result = new List<DTO_Help_Get>();
                List<Help> a = _context.Help.Where(x => x.IdProfile == id)
                    .Include(x=>x.IdDonorNavigation)
                    .Include(x=>x.IdHelptypeNavigation)
                    .Include(x=>x.IdProjectNavigation)
                    .ToList();
                AutoMapper.Mapper.Map(a, result);
                return Ok(result);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
      
        [HttpPost]
        [Route("Add/{id}")]
        public IActionResult Add([FromBody] DTO_Auth_Obj t, int id)
        {
            DTO_Help_Add a = new DTO_Help_Add();
            try
            {
                a = JsonConvert.DeserializeObject<DTO_Help_Add>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                Help result = new Help();
                AutoMapper.Mapper.Map(a, result);
                _context.Help.Add(result);
                _context.SaveChanges();
                return Ok(result);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
    }
}