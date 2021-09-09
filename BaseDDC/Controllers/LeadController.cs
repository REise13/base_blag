using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using System.Text;
using BaseDTO;
using Newtonsoft.Json;
using System.Security.Cryptography;

namespace BaseDDC.Controllers
{
    [Route("Lead")]
    [ApiController]
    public class LeadController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();

        [Route("Answers")]
        [HttpPost]
        public IActionResult GetAnswers([FromBody] DTO_Auth_Obj auth)
        {
            try
            {
                var result = new Lead_Answers()
                {

                    Bdisctrict = AutoMapper.Mapper.Map<List<LeadBdisctrict>, List<DTO_Dict>>(_context.LeadBdisctrict.AsNoTracking().ToList()),
                    Childrens = AutoMapper.Mapper.Map<List<LeadChildrens>, List<DTO_Dict>>(_context.LeadChildrens.AsNoTracking().ToList()),
                    Family = AutoMapper.Mapper.Map<List<LeadFamily>, List<DTO_Dict>>(_context.LeadFamily.AsNoTracking().ToList()),
                    Family_unempl = AutoMapper.Mapper.Map<List<LeadFamUnemp>, List<DTO_Dict>>(_context.LeadFamUnemp.AsNoTracking().ToList()),
                    Migrant = AutoMapper.Mapper.Map<List<LeadMigrant>, List<DTO_Dict>>(_context.LeadMigrant.AsNoTracking().ToList()),
                    Reason = AutoMapper.Mapper.Map<List<LeadReason>, List<DTO_Dict>>(_context.LeadReason.AsNoTracking().ToList()),
                    House = AutoMapper.Mapper.Map<List<TypeOfHouse>, List<DTO_Dict>>(_context.TypeOfHouse.AsNoTracking().ToList()),
                };
                return Ok(result);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

        [Route("AddLead")]
        public IActionResult LeadAdd([FromBody] DTO_Auth_Obj auth)
        {

            try
            {
                var new_lead = JsonConvert.DeserializeObject<DTO_Lead_Reg>(auth.obj.ToString());
                Lead lead = AutoMapper.Mapper.Map<DTO_Lead_Reg,Lead >(new_lead);
              
                _context.Lead.Add(lead);
                _context.SaveChanges();
                return Ok(lead.Id);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }

        }

        [Route("Get/{id}")]
        public IActionResult LeadAdd([FromBody] DTO_Auth_Obj auth,int id)
        {

            try
            {
                var lead = _context.Lead.Find(id);
                if (lead != null)
                {
                    try
                    {
                        var result = AutoMapper.Mapper.Map<Lead, DTO_Lead_Get>(lead);
                        return Ok(result);
                    }
                    catch (Exception ex)
                    {
                        return BadRequest(ex.Message);
                    }
                }
                else
                    return BadRequest("Такой записи не существует");

            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }

        }
    }
}